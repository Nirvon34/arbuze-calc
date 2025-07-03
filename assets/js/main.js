$(document).ready(function () {
  const $region = $('#region-select');
  const $range = $('#flowRange');
  const $flowVal = $('#flowValue');

  const limits = {
    moscow: 1200,
    spb: 800,
    ekb: 500
  };

  // Обновление диапазона прокачки при смене региона
  $region.on('change', function () {
    const selected = $(this).val();
    const max = limits[selected];
    $range.attr('max', max);
    $range.val(0);
    $flowVal.text(0);
  });

  // Отображение текущего значения прокачки
  $range.on('input', function () {
    $flowVal.text($(this).val());
  });

  // Автообновление брендов по типу топлива
  const brandOptions = {
    'бензин': ['Роснефть', 'Татнефть', 'Лукойл'],
    'газ': ['Shell', 'Газпром', 'Башнефть'],
    'дт': ['Татнефть', 'Лукойл']
  };

  $('input[name="fuel"]').on('change', function () {
    const fuelType = $(this).val();
    const brands = brandOptions[fuelType] || [];

    const $brandSelect = $('#brand-select');
    $brandSelect.empty();
    brands.forEach(brand => {
      $brandSelect.append(`<option value="${brand}">${brand}</option>`);
    });
  });

  // Первичная инициализация брендов
  $('input[name="fuel"]:checked').trigger('change');

  // Отправка формы
  $('#order-form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);

    const fuel = $('input[name="fuel"]:checked').val();
    const brand = $('#brand-select').val();

    // Обновляем скрытые поля
    $('#selected-fuel').val(fuel);
    $('#selected-brand').val(brand);

    const formData = {
      inn: $('#inn').val().trim(),
      phone: $('#phone').val().trim(),
      email: $('#email').val().trim(),
      tariff: $('#selected-tariff').val(),
      region: $('#selected-region').val(),
      fuel: fuel,
      brand: brand
    };

    const resultEl = $('#form-result');
    resultEl.text('').removeClass('text-danger text-success');

    $.ajax({
      type: 'POST',
      url: 'send.php',
      data: formData,
      dataType: 'json',
      success: function () {
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

// DOMContentLoaded — логика акций/тарифов
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

  // Обновляем скрытое поле региона
  document.getElementById("region-select").addEventListener('change', function () {
    document.getElementById("selected-region").value = this.value;
  });
});


