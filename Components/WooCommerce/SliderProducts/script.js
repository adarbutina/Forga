import { buildRefs } from '@/assets/scripts/helpers.js';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

export default function (el) {
  const refs = buildRefs(el);

  const swiper = initSlider(refs);

  return () => {
    swiper.destroy();
  }
}

function initSlider (refs) {
  const config = {
    freeMode: true,
    modules: [Navigation, Pagination],
    roundLengths: true,
    slidesPerView: 'auto',
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
  };

  return new Swiper(refs.slider, config);
}
