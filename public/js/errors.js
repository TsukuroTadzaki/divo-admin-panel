document.addEventListener('DOMContentLoaded', editHandler);
document.addEventListener('turbo:load', editHandler);

function editHandler() {
    if (window.location.href.includes('edit') || window.location.href.includes('create')) {
        for (let el of document.querySelectorAll('input')) {
            el.addEventListener('input', function () {
                for (let elem of document.querySelectorAll('#save-button')) {
                    elem.classList.add('btn-danger');
                }
            });
        }
        for (let el of document.querySelectorAll('select')) {
            el.addEventListener('change', function () {
                if (!document.getElementById('save-button').classList.contains('btn-danger')) {
                    for (let elem of document.querySelectorAll('#save-button')) {
                        elem.classList.add('btn-danger');
                    }
                }
            });
        }
    }
}

