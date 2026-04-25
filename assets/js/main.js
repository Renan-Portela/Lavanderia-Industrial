// Scripts JavaScript customizados para LuvaSul

// Validação de formulários do Bootstrap
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()

// Validação customizada para quantidades
document.addEventListener('change', function(e) {
    if (e.target && e.target.type === 'number' && e.target.name === 'quantidade') {
        if (e.target.value <= 0) {
            e.target.setCustomValidity('A quantidade deve ser maior que zero.');
        } else {
            e.target.setCustomValidity('');
        }
    }
});

// Inicialização de Toasts do Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, { delay: 5000 })
    })
    toastList.forEach(toast => toast.show())
});

// Auto-hide alerts fixos (não Toasts) após 8 segundos se não forem de erro
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert:not(.alert-danger)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 8000);
    });
});

// Focar no campo de QR Code quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    const qrInput = document.getElementById('codigo_qr');
    if (qrInput) {
        qrInput.focus();
    }
});

// Função para imprimir QR Code
function imprimirQRCode() {
    window.print();
}

// Função para copiar código QR
function copiarCodigoQR(codigo) {
    navigator.clipboard.writeText(codigo).then(function() {
        // Usar toast customizado se disponível futuramente, por enquanto alert nativo
        alert('Código copiado: ' + codigo);
    });
}
