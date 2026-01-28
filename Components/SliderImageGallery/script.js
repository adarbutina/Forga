import { buildRefs } from '@/assets/scripts/helpers.js';
import Swiper from 'swiper';
import { Pagination, Navigation, Thumbs } from 'swiper/modules';

export default function (el) {
  const refs = buildRefs(el);

  const swipers = initSliders(refs);

  return () => {
    swipers.forEach(swiper => swiper.destroy());
  }
}

function initSliders (refs) {
  const swiperSliderThumb = new Swiper(refs.sliderThumb, {
    freeMode: true,
    slidesPerView: 'auto',
    slideToClickedSlide: true,
    lazy: {
      loadPrevNext: true,
      loadPrevNextAmount: 10
    }
  });

  const swiperSliderMain = new Swiper(refs.sliderMain, {
    modules: [Pagination, Navigation, Thumbs],
    slidesPerView: 'auto',
    roundLengths: true,
    pagination: {
      el: refs.pagination,
      clickable: true
    },
    navigation: {
      nextEl: refs.next,
      prevEl: refs.prev
    },
    thumbs: {
      swiper: refs.sliderThumb,
    },
  });

  return [swiperSliderMain, swiperSliderThumb];
}
