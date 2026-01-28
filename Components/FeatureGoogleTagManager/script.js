/* globals PurchaseData */

export default function () {
  window.dataLayer = window.dataLayer || [];

  const isPurchase = document.body.classList.contains('woocommerce-order-received');

  onPageView();

  function onPageView() {
    initConsent();
    updateConsent();

    if (isPurchase) {
      window.dataLayer.push({
        event: 'purchase',
        ecommerce: PurchaseData
      });
    }

    console.log(dataLayer);
  }
}

function initConsent() {
  window.dataLayer.push({
    consent: 'default',
    ad_storage: 'denied',
    ad_user_data: 'denied',
    ad_personalization: 'denied',
    analytics_storage: 'denied'
  });
}

function updateConsent() {
  window.dataLayer.push({
    consent: 'update',
    ad_storage: 'granted',
    ad_user_data: 'granted',
    ad_personalization: 'granted',
    analytics_storage: 'granted'
  });
}
