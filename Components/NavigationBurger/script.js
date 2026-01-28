import { buildRefs } from '@/assets/scripts/helpers.js';
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';

export default function (el) {
  const refs = buildRefs(el);

  refs.popover.addEventListener('toggle', setPopover);

  function setPopover(e) {
    if (e.newState === 'open') {
      disableBodyScroll(refs.popover);
      document.body.style.setProperty('pointer-events', 'none');
    } else {
      enableBodyScroll(refs.popover);
      document.body.style.removeProperty('pointer-events');
    }
  }

  return () => {
    refs.popover.removeEventListener('toggle', setPopover);
  }
}
