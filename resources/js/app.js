import "./bootstrap";

import Swiper from "swiper";
import sort from "@alpinejs/sort";
import mask from "@alpinejs/mask";

import { notifications, notify } from './notification.js';

import { Chart, registerables } from "chart.js";

import { Navigation, Pagination, Autoplay, Thumbs } from "swiper/modules";

Alpine.data('notifications', notifications)

Alpine.plugin(notify)

Alpine.plugin(sort);

Alpine.plugin(mask);

Swiper.use([Navigation, Pagination, Autoplay, Thumbs]);
Chart.register(...registerables);
window.Chart = Chart;

alert('adi')
