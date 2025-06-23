import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
import $ from 'jquery';
window.$ = window.jQuery = $;
import 'select2/dist/css/select2.css';
import 'select2';
import Tagify from '@yaireo/tagify';
import '@yaireo/tagify/dist/tagify.css';

$(document).ready(function() {
  $('#tags').select2({
    tags: true,
    tokenSeparators: [','],
    placeholder: 'Escreva ou selecione tags',
    width: '100%',
  });
});

const input = document.querySelector('select#tags');
new Tagify(input, {
  whitelist: [ ],
  dropdown: {
    enabled: 1,      
    maxItems: 20,
  }
});

Alpine.start();
