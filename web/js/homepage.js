var allTasks       = [];
var fullTaskBuffer = []; //Место где будут хранится загруженные задачи (при клике на ссылку)

loadTasks();

/**
 * Обработка поисковой формы
 */
$('#search').on('change paste keyup', function(event) {
    var foundTasks = search(event.currentTarget.value);
    viewTasks(foundTasks, 10, 1);
    updatePaginator(foundTasks);
});


       
/**
 * Отображение задач на странице
 * @param {array} tasks
 * @param {integer} countPerPage
 * @param {integer} page
 */
function viewTasks(tasks, countPerPage, page) {
    var currentTasks = [];
    if (countPerPage > 0 && page >= 1 && page <= Math.ceil(tasks.length / countPerPage)) {
            var startTask = ((page - 1) * countPerPage);
            var endTask = page * countPerPage;
          
            for (var i = startTask; i < endTask; i++) {
                currentTasks.push(tasks[i]);
            }
    }
    
    $('#taskview').html('');
    
    $.map(currentTasks, function(currentTask, index) {
        if (currentTask) {
            $('#taskview').append('<tr>\n\
                                    <td><a data-toggle="modal" data-target="#exampleModal" href="#" class="tasklink" data-id="' + currentTask.id + '">' + currentTask.id + '</a></td>\n\
                                    <td><a data-toggle="modal" data-target="#exampleModal" href="#" class="tasklink" data-id="' + currentTask.id + '">' + currentTask.title + '</a></td>\n\
                                    <td><a data-toggle="modal" data-target="#exampleModal" href="#" class="tasklink" data-id="' + currentTask.id + '">' + currentTask.date + '</a></td>\n\
                                   </tr>');
        }
    });
    
    tasklinkHandler();
}

/**
 * Загрузка задач с сервера
 */
function loadTasks() {   
    $.get(tasklistUrl, '', function (response) {
        var tasks = [];
        $.map(response, function(value, index) {
            tasks.push(value); 
        });
        allTasks = tasks;
        viewTasks(tasks, 10, 1); //Отображаем 10 задач из первой страницы
        updatePaginator(tasks);
    });
}

/**
 * Поиск задач по названию
 * @param {String} keywordsString
 * @returns {Array}
 */
function search(keywordsString) {
    var foundedTasks = [];
    
    if (keywordsString) {
        var keywords = keywordsString.split(' ');
        
        $.map(allTasks, function(task, index) {
            var searchResult = true;
            $.map(keywords, function(keyword, i) {
                if (task.title.toLowerCase().indexOf(keyword.toLowerCase()) === -1) {
                    searchResult = false;
                }
            });
            
            if (searchResult) {
                foundedTasks.push(task);
            }
        });
    } else {
        foundedTasks = allTasks;
    }
    
    return foundedTasks;
}

/**
 * Обновить пагинатор
 * @param {Array} tasks
 */
function updatePaginator(tasks) {
    $('#pagination').empty();
    $('#pagination').removeData("twbs-pagination");
    $('#pagination').unbind("page");
    
    window.pagObj = $('#pagination').twbsPagination({
        totalPages: Math.ceil(tasks.length / 10),
        visiblePages: 10,
    }).on('page', function (event, page) {
        viewTasks(tasks, 10, page);
    });
}

/**
 * Нажатие на ссылку задачи
 */
function tasklinkHandler() {
    $('.tasklink').on('click', function(event) {
        event.preventDefault();
        var taskId = event.currentTarget.dataset.id;
        clearModal();
        //Запрос данных по задаче
        if (!fullTaskBuffer[taskId]) {
            $.get(tasklistUrl + '/' + taskId, '', function (task) {
                fullTaskBuffer[taskId] = task;
                fillModal(task);
            });
        } else {
            fillModal(fullTaskBuffer[taskId]);
        }
    });
}

function clearModal() {
    $("#exampleModalLabel").html('Идет загрузка...');
    $("#exampleModalBody").html('');
}

/**
 * Заполнить модальное окно с задачей
 * @param {object} task
 */
function fillModal(task) {
    $("#exampleModalLabel").html('Информация о задаче №' + task.id);
    $("#exampleModalBody").html('<table>\n\
                                        <tr><td style="padding-right: 20px;">Заголовок:</td><td>' + task.title + '</td></tr>\n\
                                        <tr><td>Дата: </td><td>' + task.date + '</td></tr>\n\
                                        <tr><td>Автор: </td><td>' + task.author + '</td></tr>\n\
                                        <tr><td>Статус: </td><td>' + task.status + '</td></tr>\n\
                                        <tr><td>Описание: </td><td>' + task.description + '</td></tr>\n\
                                 </table>');
}