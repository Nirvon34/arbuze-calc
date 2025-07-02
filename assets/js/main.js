// Логика выбора тарифа и региона
document.addEventListener("DOMContentLoaded", () => {
  const promoText = document.getElementById("promoText");
  const savingText = document.getElementById("savingText");
  const selectedTariffLabel = document.getElementById("selectedTariffLabel");
  const selectedTariffInput = document.getElementById("selected-tariff");
  const tariffRadios = document.querySelectorAll("input[name='tariff']");

  const promos = {
    'tariff1': { label: "Промо-акция: -30%", saving: "1 500 ₽", name: "Избранный" },
    'tariff2': { label: "Промо-акция: -10%", saving: "500 ₽", name: "Эконом" },
    'tariff3': { label: "Промо-акция: -50%", saving: "2 500 ₽", name: "Премиум" }
  };

  // Обновление при клике на тариф
  tariffRadios.forEach(radio => {
    radio.addEventListener('click', () => {
      const id = radio.id;
      const promo = promos[id];

      if (promo) {
        promoText.textContent = promo.label;
        savingText.textContent = "Ваша экономия: " + promo.saving;
        selectedTariffLabel.textContent = promo.name;
        selectedTariffInput.value = promo.name;
      }
    });
  });

  // Обновление скрытого поля региона
  document.getElementById("region-select").addEventListener('change', function () {
    document.getElementById("selected-region").value = this.value;
  });
});

// AJAX-отправка формы
$(document).ready(function () {
  $('#order-form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const formData = {
      inn: $('#inn').val().trim(),
      phone: $('#phone').val().trim(),
      email: $('#email').val().trim(),
      tariff: $('#selected-tariff').val(),
      region: $('#selected-region').val()
    };

    const resultEl = $('#form-result');
    resultEl.text('').removeClass('text-danger text-success');

    $.ajax({
      type: 'POST',
      url: 'send.php',
      data: formData,
      dataType: 'json',
      success: function (response) {
        form[0].reset();
        $('#orderModal').modal('hide');
        resultEl.text('Спасибо! Успешно отправлено.').addClass('text-success');
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.error || 'Произошла ошибка при отправке.';
        resultEl.text('Ошибка: ' + msg).addClass('text-danger');
      }
    });
  });
});
