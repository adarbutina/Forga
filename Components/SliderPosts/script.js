import { buildRefs } from '@/assets/scripts/helpers.js';
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

export default function (el) {
  const refs = buildRefs(el);

  const swiper = initSlider(refs);

  return () => {
    swiper.destroy();
  }
}

function initSlider (refs) {
  const config = {
    modules: [Navigation],
    roundLengths: true,
    slidesPerView: 'auto',
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
  };

  return new Swiper(refs.slider, config);
}
