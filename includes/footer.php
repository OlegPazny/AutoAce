
    <footer class="footer">
        <div class="footer__logo">
            <a href="../index.php">
                <div class="footer__logo__block">
                    <img alt="Иконка логотипа темная" src="../assets/images/gear_icon_dark.svg">
                    <img alt="Текст логотипа темный" src="../assets/images/logo_text_dark.svg">
                </div>
            </a>
        </div>
        <div class="footer__search">
            <a href="../pages/map.php">
                Поиск автосервиса
            </a>
        </div>
        <div class="footer__contact-info">
            <p><a href="tel:+375298657968">+375 (29) 865-79-68</a></p>
        </div>
        <div class="footer__address">
            <p>г. Минск, ул. Савицкого, 3</p>
        </div>
    </footer>
<!-- <script>
function adjustSectionsHeight() {
            // Получаем высоты элементов
            const headerHeight = getComputedStyle(document.querySelector('header')).height.slice(0, -2);
            const footerHeight = getComputedStyle(document.querySelector('footer')).height.slice(0, -2);
            const windowHeight = window.screen.height;
            console.log(headerHeight);
            console.log(footerHeight);
            console.log(windowHeight);

            // Получаем все секции на странице
            const sectionHeight = getComputedStyle(document.querySelector('.account-section')).height.slice(0, -2);
            console.log(sectionHeight);
            // Вычисляем минимальную высоту для контента
            const contentMinHeight = windowHeight - headerHeight - footerHeight;
            const marginForFooter = windowHeight - footerHeight*2 - headerHeight*2 - sectionHeight;
            console.log(marginForFooter);
            // Устанавливаем минимальную высоту для контейнера с контентом
            document.querySelector('footer').style.marginTop = marginForFooter + 'px';
        }

        // Вызываем функцию при загрузке страницы и изменении размера окна
        window.addEventListener('load', adjustSectionsHeight);
        window.addEventListener('resize', adjustSectionsHeight);
        window.addEventListener('click', adjustSectionsHeight);
</script> -->