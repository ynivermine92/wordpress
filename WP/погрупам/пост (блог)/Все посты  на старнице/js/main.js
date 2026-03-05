 const blogsFilterAjax = () => {
    const blogsWrapper = document.querySelector('.blogs__category');
    const wrapperPagination = document.querySelector('.pagination');
    let currentCategory = ''; // сохраняем выбранную категорию



    // AJAX запрос
    async function BlogsAjax(categoryId, pageId = '') {
      try {
        const formData = new FormData();
        formData.append('action', 'filter_blogs');
        formData.append('categoryId', categoryId);
        formData.append('pageId', pageId);

        const response = await fetch('/wp-admin/admin-ajax.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();
        
        if (result.success) {
          blogsWrapper.innerHTML = result.data.posts;  /* отресовыем посты из буфера */
          wrapperPagination.innerHTML = result.data.pagination; /* отресовыем пагинацию */
          paginationBlogs(); // навешиваем обработчики на новую пагинацию
        } else {
          console.error('Ошибка сервера:', result);
        }
      } catch (err) {
        console.error('Ошибка fetch:', err);
      }
    }

    // Категории
    const CategorysBlogs = () => {
      const buttons = document.querySelectorAll('.blogs__btn');
      buttons.forEach(button => {
        button.addEventListener('click', () => {
          buttons.forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');
          currentCategory = button.dataset.categoryId;
     
          BlogsAjax(currentCategory, 1); // при смене категории всегда первая страница
        });
      });

      // Устанавливаем начальную категорию
      const activeBtn = document.querySelector('.blogs__btn.active');
      if (activeBtn) currentCategory = activeBtn.dataset.categoryId;
    };
    // навешиваем категории
    CategorysBlogs();



    // Пагинация
    const paginationBlogs = () => {
      const paginationBtns = document.querySelectorAll('.pagination__item:not(.disabled)');
      paginationBtns.forEach(item => {
        item.addEventListener('click', e => {
          e.preventDefault();
          const pageId = item.dataset.paginationId;
          if (currentCategory) {
            BlogsAjax(currentCategory, pageId);
          }
        });
      });
    };

    paginationBlogs()
  };

  blogsFilterAjax();

