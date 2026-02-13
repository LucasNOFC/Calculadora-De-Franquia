const inputFipe = document.getElementById('fipeValue');

const formatter = new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});

inputFipe.addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');

    if (!value) {
        e.target.value = '';
        return;
    }

    value = formatter.format(value / 100);
    e.target.value = value;
});

const inputPercentage = document.getElementById('fipePercentage');

inputPercentage.addEventListener('input', function () {
    let value = this.value.replace(/\D/g, '');

    if (value.length > 3) {
        value = value.slice(0, 3);
    }

    if (value > 100) {
        value = 100;
    }

    this.value = value;
});