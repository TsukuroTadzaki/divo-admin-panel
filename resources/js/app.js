import * as Turbo from '@hotwired/turbo';
import * as Bootstrap from 'bootstrap';

import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';
import ApplicationController from './controllers/application_controller';

import FieldsRepeater from './controllers/fields/repeater_controller';
import CKEditorController from './controllers/fields/ckeditor_controller'

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

//darkmode
window.addEventListener('turbo:load', (event) => {
    let toggler = document.getElementById('darkmodeToggle')
    let navbar = document.getElementById('navbar-section')
    let sidebar = document.getElementById('aside-section')

    //init theme on load
    let initTheme = localStorage.getItem('theme') || 'dark'
    if (initTheme === 'dark') {
        setDark()
    } else if (initTheme === 'light') {
        setLight()
    }

    //toggle theme event
    toggler.addEventListener('click', function() {
        let currentTheme = localStorage.getItem('theme') || 'dark'
        if (currentTheme === 'dark') {
            setLight()
        } else if (currentTheme === 'light') {
            setDark()
        }
    })

    //set dark theme
    function setDark() {
        toggler.firstElementChild.setAttribute('fill', '#fff')
        navbar.classList.remove('bg-white')
        navbar.classList.add('bg-dark')
        sidebar.classList.remove('bg-white')
        sidebar.classList.add('bg-dark')
        localStorage.setItem('theme', 'dark')
    }

    //set light theme
    function setLight() {
        toggler.firstElementChild.setAttribute('fill', '#000')
        navbar.classList.remove('bg-dark')
        navbar.classList.add('bg-white')
        sidebar.classList.remove('bg-dark')
        sidebar.classList.add('bg-white')
        localStorage.setItem('theme', 'light')
    }
});