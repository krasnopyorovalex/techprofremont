jQuery(function() {
    /*
     |-----------------------------------------------------------
     |   left navigation
     |-----------------------------------------------------------
     */
    var sidebar_li = jQuery('.sidebar-category li > a'),
        pathname = window.location.pathname.replace(/\/add|\/delete\/(\d+)|\/product\/list\/(\d+)|\/product\/list\/(\d+)|\/delete-item\/(\d+)|\/edit-item\/(\d+)|\/items\/(\d+)|\/update\/(\d+)/g, '');
    sidebar_li.each(function () {
        if (jQuery(this).attr('href') == pathname) {
            //return jQuery(this).closest('.dark-nav').addClass('active') && jQuery(this).closest('.dark-nav > ul').addClass('in') && jQuery(this).parent('li').addClass('active');
            return jQuery(this).parent('li').addClass('active');
        }
    });

    /*
     |-----------------------------------------------------------
     |   Удаление изображение
     |-----------------------------------------------------------
     */
    var btn_action = jQuery('.thumbnail-single .remove_image'),
        action     = window.location.pathname.replace('update','remove-image');
    btn_action.on('click', function () {
        if(confirm('Вы уверены, что хотите удалить изображение?')){
            var _this = jQuery(this);
            return $.ajax({
                url: action,
                type: "POST",
                success: function() {
                    return _this.closest('div.thumbnail-single').fadeOut() && jQuery.jGrowl('Изображение удалено успешно', { theme: 'bg-slate-700', header: 'Сообщение из конторы' });
                }
            });
        }
    });

    /*
   |-----------------------------------------------------------
   |   edit image
   |-----------------------------------------------------------
   */
    var editImageBox = jQuery('#edit-image'),
        imagesBox = jQuery('#_images_box');
    imagesBox.on('click', '.icon-pencil', function () {
        $.post(jQuery(this).closest('a').attr('data-link'), function(data){
            return editImageBox.html(data);
        });
    });

    editImageBox.on('click', '#edit_image_button', function (e) {
        e.preventDefault();
        return jQuery.ajax({
            url: jQuery(this).closest('form').attr('action'),
            type: "POST",
            dataType: "json",
            data: jQuery(this).closest('form').serialize(),
            error: function (error, message) {
                jQuery.jGrowl('Произошла ошибка, попробуйте позже:(', {
                    theme: 'bg-slate-700',
                    header: 'Сообщение из конторы'
                });
            },
            success: function(data) {
                editImageBox.modal('hide');
                jQuery.jGrowl('Информация об изображении сохранена успешно:)', {
                    theme: 'bg-slate-700',
                    header: 'Сообщение из конторы'
                });
                return imagesBox.html(data);
            }
        });
    });

    /*
     |-----------------------------------------------------------
     |   Удаление изображения из списка в галерее
     |-----------------------------------------------------------
     */
    imagesBox.on('click', '.icon-trash', function (e) {
        e.preventDefault();
        if(confirm('Вы уверены, что хотите удалить изображение?')) {
            var _this = jQuery(this);
            return $.ajax({
                url: _this.parent('a').attr('href'),
                type: "POST",
                success: function () {
                    return _this.closest('li').fadeOut() && jQuery.jGrowl('Изображение галереи удалено успешно', {
                            theme: 'bg-slate-700',
                            header: 'Сообщение из конторы'
                        });
                }
            });
        }
    });

    /*
    |-----------------------------------------------------------
    |   generate alias from name
    |-----------------------------------------------------------
    */
    var fromGenerate = jQuery('#from__generate'),
        toGenerate = jQuery('#to__generate'),
        eventTarget = jQuery('.form-group .input-group-addon');
    eventTarget.on('click', function () {
        toGenerate.val(transliterate(fromGenerate.val()));
    });
});

function transliterate(text) {
    var space = '-';
    // Берем значение из нужного поля и переводим в нижний регистр
    text = text.toLowerCase();

    // Массив для транслитерации
    var transl = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
        'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
        'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': 'y', 'ы': 'y', 'ь': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya',
        ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
        '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
        '(': space, ')': space,'-': space, '\=': space, '+': space, '[': space,
        ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
        '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
        '?': space, '<': space, '>': space, '№':space
    };

    var result = '',
        current_sim = '',
        i = 0;

    for(i; i < text.length; i++) {
        // Если символ найден в массиве то меняем его
        if(transl[text[i]] != undefined) {
            if(current_sim != transl[text[i]] || current_sim != space){
                result += transl[text[i]];
                current_sim = transl[text[i]];
            }
        }
        // Если нет, то оставляем так как есть
        else {
            result += text[i];
            current_sim = text[i];
        }
    }

    result = result.replace(/^-/, '');
    return result.replace(/-$/, '');
}