import intlTelInput from 'intl-tel-input';
import 'intl-tel-input/build/css/intlTelInput.css';

export default function (el) {
  const phone = el.querySelector('#billing_phone');

  const iti = initIti(phone);

  return () => {
    iti.destroy();
  }
}

function initIti (el) {
  const config = {
    loadUtils: () => import("intl-tel-input/utils"),
  };

  return intlTelInput(el, config);
}
