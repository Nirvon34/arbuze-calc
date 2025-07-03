<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Калькулятор тарифа</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>

  <div class="container mt-5">
    <h1 class="text-center mb-4">Калькулятор тарифа</h1>

    <!-- Регион -->
    <div class="row justify-content-center">
      <div class="col-md-6">
        <label for="region-select" class="form-label">Выберите регион:</label>
        <select id="region-select" class="form-select" name="region">
          <option value="moscow">Москва</option>
          <option value="spb">Санкт-Петербург</option>
          <option value="ekb">Екатеринбург</option>
        </select>
      </div>
    </div>

    <!-- Прокачка -->
    <div class="row justify-content-center mt-4">
      <div class="col-md-6 text-center">
        <label for="flowRange" class="form-label">Выберите объем прокачки (тонн): <span id="flowValue">0</span> т</label>
        <input type="range" class="form-range" min="0" max="1200" step="100" id="flowRange" value="0">
      </div>
    </div>

    <!-- Тип топлива -->
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <label class="form-label">Выберите тип топлива:</label>
        <div class="btn-group w-100" role="group" aria-label="Тип топлива">
          <input type="radio" class="btn-check" name="fuel" id="fuel-gasoline" value="бензин" autocomplete="off" checked>
          <label class="btn btn-outline-secondary" for="fuel-gasoline">Бензин</label>

          <input type="radio" class="btn-check" name="fuel" id="fuel-gas" value="газ" autocomplete="off">
          <label class="btn btn-outline-secondary" for="fuel-gas">Газ</label>

          <input type="radio" class="btn-check" name="fuel" id="fuel-diesel" value="дт" autocomplete="off">
          <label class="btn btn-outline-secondary" for="fuel-diesel">ДТ</label>
        </div>
      </div>
    </div>

    <!-- Выбор бренда -->
    <div class="row justify-content-center mt-4">
      <div class="col-md-6">
        <label class="form-label" for="brand-select">Выберите бренд:</label>
        <select id="brand-select" class="form-select" name="brand">
          <option value="Роснефть">Роснефть</option>
          <option value="Татнефть">Татнефть</option>
          <option value="Лукойл">Лукойл</option>
        </select>
      </div>
    </div>

    <!-- Тарифы -->
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <div class="btn-group w-100" role="group" aria-label="Выбор тарифа">
          <input type="radio" class="btn-check" name="tariff" id="tariff1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="tariff1" data-tariff="Избранный">Избранный</label>

          <input type="radio" class="btn-check" name="tariff" id="tariff2" autocomplete="off">
          <label class="btn btn-outline-primary" for="tariff2" data-tariff="Эконом">Эконом</label>

          <input type="radio" class="btn-check" name="tariff" id="tariff3" autocomplete="off">
          <label class="btn btn-outline-primary" for="tariff3" data-tariff="Премиум">Премиум</label>
        </div>
      </div>
    </div>

    <!-- Акция и экономия -->
    <div class="row justify-content-center mt-4">
      <div class="col-md-6 text-center">
        <div class="promo-text fw-bold mb-2" id="promoText">Промо-акция: -30%</div>
        <div class="saving-text text-success fs-5" id="savingText">Ваша экономия: 1 500 ₽</div>
      </div>
    </div>

    <!-- Кнопка -->
    <div class="text-center mt-4">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal">
        Заказать тариф «<span id="selectedTariffLabel">Избранный</span>»
      </button>
    </div>
  </div>

  <!-- Модальное окно -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="order-form">
          <div class="modal-header">
            <h5 class="modal-title">Заказ тарифа</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="inn" class="form-label">ИНН</label>
              <input type="text" class="form-control" name="inn" id="inn" required pattern="\d{12}" maxlength="12">
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Телефон</label>
              <input type="text" class="form-control" name="phone" id="phone" required pattern="\d{11}" maxlength="11">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="accept" required>
              <label class="form-check-label" for="accept">Я соглашаюсь с условиями</label>
            </div>

            <!-- Скрытые поля -->
            <input type="hidden" name="tariff" id="selected-tariff" value="Избранный">
            <input type="hidden" name="region" id="selected-region" value="moscow">
            <input type="hidden" name="fuel" id="selected-fuel">
            <input type="hidden" name="brand" id="selected-brand">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Отправить</button>
          </div>
          <div id="form-result" class="text-center mt-2"></div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS библиотеки -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

</body>
</html>
