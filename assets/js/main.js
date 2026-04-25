// Scripts JavaScript customizados

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

// Auto-hide alerts após 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
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
        alert('Código copiado para a área de transferência!');
    });
}

