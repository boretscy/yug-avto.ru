/**
 * FormHandler - Изолированный менеджер валидации и отправки форм (Vanilla JS, fetch API)
 */
class FormHandler {
    constructor(formElement) {
        if (!formElement || !(formElement instanceof HTMLFormElement)) {
            return;
        }
        this.form = formElement;
        this.sid = this.form.dataset.sid || '';
        this.isSubmitting = false;
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        const sendBtn = this.form.querySelector('[role="sendForm"]');
        if (sendBtn) {
            sendBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSubmit(e);
            });
        }
    }

    async handleSubmit(e) {
        if (e) e.preventDefault();
        if (this.isSubmitting) return;

        if (!this.validate()) {
            return;
        }

        this.isSubmitting = true;
        const submitBtn = this.form.querySelector('[role="sendForm"], button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        const formData = new FormData(this.form);
        const payload = new URLSearchParams();
        for (const [key, value] of formData.entries()) {
            payload.append(key, value);
        }

        try {
            const response = await fetch('/api/send_new/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: payload.toString()
            });

            const res = await response.json();

            if (res && res.status === 'success') {
                this.showStatus('success');
                this.sendCallTouch(Object.fromEntries(formData.entries()));
                if (window.ym && this.sid) {
                    try { window.ym(6251896, 'reachGoal', this.sid); } catch(err) {}
                }
            } else {
                this.showStatus('error');
            }
        } catch (err) {
            console.error('Form submission error:', err);
            this.showStatus('error');
        } finally {
            this.isSubmitting = false;
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    validate() {
        let valid = true;
        const requiredInputs = this.form.querySelectorAll('[required], .required');

        requiredInputs.forEach(input => {
            const val = input.value ? input.value.trim() : '';
            if (!val) {
                input.classList.add('is-invalid');
                valid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return valid;
    }

    sendCallTouch(data) {
        if (!window['call_value_78d47ede']) return;
        const rawPhone = data.PHONE || data.phone || '';
        const phone = rawPhone.replace(/[^\d]/g, '');
        if (!phone) return;

        const subject = encodeURIComponent('Формы - ' + (data.FORM || 'Заявка с сайта'));
        const fio = encodeURIComponent(data.NAME || data.name || '');
        const sessionId = window['call_value_78d47ede'];

        const url = `https://api.calltouch.ru/calls-service/RestAPI/requests/20621/register/?subject=${subject}&sessionId=${sessionId}&fio=${fio}&phoneNumber=${phone}`;

        fetch(url, { mode: 'no-cors' }).catch(() => {});
    }

    showStatus(type) {
        const parent = this.form.parentElement || document;
        const successEl = parent.querySelector('[role="success"]');
        const errorEl = parent.querySelector('[role="error"]');

        if (type === 'success') {
            if (successEl) successEl.classList.remove('d-none');
            if (errorEl) errorEl.classList.add('d-none');
            this.form.classList.add('d-none');
        } else {
            if (errorEl) errorEl.classList.remove('d-none');
        }
    }

    static autoInit() {
        document.querySelectorAll('form[role="form"]').forEach(form => {
            if (!form.__formHandler) {
                form.__formHandler = new FormHandler(form);
            }
        });
    }
}

if (typeof window !== 'undefined') {
    window.FormHandler = FormHandler;
}

// Автоматическая инициализация при загрузке DOM
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => FormHandler.autoInit());
    } else {
        FormHandler.autoInit();
    }
}
