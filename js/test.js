(function() {
'use strict';
    const _regexString = /^[A-Z][a-z]+( +[A-Z][a-z]+)*$/;
    const _regexEmail = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
    const _regexSpace = /\s/;
    const _regexNonSpace = /\S/;

    const name = document.getElementById('name');
    const subject = document.getElementById('subject');
    const email = document.getElementById('email');
    const message = document.getElementById('message');

    const submit = document.querySelector('.form-submit');
    const form = document.querySelector('.contact-form');

    var isEmpty = a => a.every(el => el.replace(_regexSpace, '').length > 0),
        xhr = new XMLHttpRequest(),
        validate = function(n, s, e, m) {
            var validN = n.value || '',
                validS = s.value || '',
                validE = e.value || '',
                validM = m.value || '';

            if(isEmpty([n.value, s.value, e.value, m.value])) {
                var data = new FormData(form);
                data.append('message', m.value);
                return data;
            }
            return false;
        },
        addSuccess = function(element) {
            if(element.classList.contains('error')) {
                element.classList.remove('error');
                element.classList.add('success');
            } else {
                element.classList.add('success');
            }
        },
        addError = function(element) {
            if(element.classList.contains('success')) {
                element.classList.remove('success');
                element.classList.add('error');
            } else {
                element.classList.add('error');
            }
        },
        checkInput = function(regex, element) {
            if(regex.test(element.value)) {
                addSuccess(element);
            } else {
                addError(element);
            }
        };

    // message.addEventListener('keyup', function(e) {
    //     checkInput(_regexNonSpace, e.target);
    // }, false);
    //
    // email.addEventListener('keyup', function(e) {
    //     checkInput(_regexEmail, e.target);
    // }, false);
    //
    // name.addEventListener('keyup', function(e) {
    //     checkInput(_regexString, e.target);
    // }, false);
    //
    // subject.addEventListener('keyup', function(e) {
    //     checkInput(_regexString, e.target);
    // }, false);
    //TODO: Remove click event listener since when press tabbing its notwokring
    form.addEventListener('click    ', function(e) {
        console.log("Hi");
        var input = e.target || e.srcElement;
        if(input.nodeName === 'INPUT' || input.nodeName === 'TEXTAREA') {
            input.addEventListener('keyup', function(event) {
            var element = event.target || event.srcElement
                switch (element.id.toLowerCase()) {
                    case 'name':
                    case 'subject':
                        checkInput(_regexString, input);
                    break;
                    case 'email':
                        checkInput(_regexEmail, input);
                    break;
                    case 'message':
                        checkInput(_regexNonSpace, input);
                    break;

                    default: return;
                }
            }, false);
        }
    }, false);

    submit.addEventListener('click', function(e) {
        e.preventDefault();
        submit.disabled = true;

        if(validate(name, subject, email, message)) {
            console.log(message.value);
        } else {
            console.log("hi");
        }

        // submit.disabled = true;

        // xhr.onreadystatechange = function() {
        //     if(xhr.readyState === 4 && xhr.status === 200) {
        //         submit.disabled = false;
        //         console.log(xhr);
        //         console.log(JSON.parse(xhr.response));
        //     }
        // }
        //
        // xhr.open(form.method.toUpperCase(), form.action, true);
        // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // xhr.send(validate(name, subject, email, message));
     }, false);

})();