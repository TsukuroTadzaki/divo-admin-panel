import * as Turbo from '@hotwired/turbo';
import * as Bootstrap from 'bootstrap';

import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';
import ApplicationController from './controllers/application_controller';

import CKEditorController from './controllers/fields/ckeditor_controller';
import FieldsRepeater from './controllers/fields/repeater_controller';

window.Turbo = Turbo;
window.Bootstrap = Bootstrap;
window.application = Application.start();
window.Controller = ApplicationController;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));

window.addEventListener('turbo:before-fetch-request', (event) => {
    let state = document.getElementById('screen-state').value;

    if (state.length > 0) {
        event.detail?.fetchOptions?.body?.append('_state', state)
    }
});

if (typeof window.application !== 'undefined') {
    window.application.register('fields--repeater', FieldsRepeater);
    window.application.register("ckeditor", CKEditorController);
}

document.addEventListener('turbo:load', () => {
    checkTabs()
    if (localStorage.getItem('tab')) {
        document.querySelectorAll('.tab-head-wrapper a').forEach(tab => {
            if (tab.getAttribute('data-id').substring(1) === localStorage.getItem('tab')) {
                tab.click();
            }
        });
    }
    document.querySelectorAll('.tab-head-wrapper a').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab-head-wrapper a').forEach(tab => {tab.classList.remove('active')});
            tab.classList.add('active');
            const targetId = tab.getAttribute('data-id').substring(1); // Remove '#' from href
            localStorage.setItem('tab', targetId);
            document.querySelectorAll('#tabContent .content').forEach(content => {
                if (content.id === targetId) {
                    content.classList.add('active');
                } else {
                    content.classList.remove('active');
                }
            });
        });
    });
});
// document.addEventListener('turbo:render', function (event) {
//     checkTabs()
// });
function checkTabs() {
    if (localStorage.getItem('tab')) {
        document.querySelectorAll('.tab-head-wrapper a').forEach(tab => {
            if (tab.getAttribute('data-id').substring(1) === localStorage.getItem('tab')) {
                tab.click();
            }
        });
    }
}
document.addEventListener('turbo:load', function (event) {
    checkTabs()
});
