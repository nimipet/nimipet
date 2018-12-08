import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    nimi: {
      id: '',
      current_time: '',
      food_today: '',
      food_progress: 0,
      food_started: '',
      food_status: '',
      nimi_born: '',
      nimi_lastfed: '',
      nimi_name: '',
      nimi_points: '',
      nimi_position: '',
      nimi_state: '',
      nimi_meta: '',
      nimi_mood: '',
      nimi_temp: '',
      nimi_style: {
        color1: "#e4e4e4",
        color2: "#FDFDFD",
        color3: "#ffffff",
        skin_url: "undefined",
        x1: "1",
        x2: "0.8428121700606598",
        y1: "1",
        y2: "-0.11844952587765922",
      },
      nimi_value: '',
      nimiq_address: '',
      nimi_price: '',
      nimi_msg: '',
      referral_id: '',
      referred_by: '',
      registered: '',
      user_id: ''
    },
    items: {
      food: {
        burger: 0,
        water: 0,
        durian: 0,
        peyote: 0,
        pepper: 0,
        pills: 0
      },
      magic: {
        resurrection: 0,
        hibernation: 0,
        sunglasses: 0
      }
    },
    modal: false,
    styleChange: false,
    speech: '',
    timePassed: '--',
    language: 'en',
    form: '',
    referred_by: '',
    loaded: false
  },
  mutations: {
    referred_by (state, referred_by) {
      state.referred_by = referred_by;
    },
    loaded (state, loaded) {
      state.loaded = loaded;
    },
    form (state, form) {
      state.form = form;
    },
    language (state, language) {
      state.language = language;
    },
    nimi (state, { property, value }) {
      state.nimi[property] = value;
    },
    items (state, { type, item, available }) {
      state.items[type][item] = available;
    },
    modal (state, modal) {
      state.modal = modal;
    },
    color1 (state, color) {
      state.nimi.nimi_style.color1 = color;
    },
    color2 (state, color) {
      state.nimi.nimi_style.color2 = color;
    },
    color3 (state, color) {
      state.nimi.nimi_style.color3 = color;
    },
    x1 (state, value) {
      state.nimi.nimi_style.x1 = value;
    },
    x2 (state, value) {
      state.nimi.nimi_style.x2 = value;
    },
    y1 (state, value) {
      state.nimi.nimi_style.y1 = value;
    },
    y2 (state, value) {
      state.nimi.nimi_style.y2 = value;
    },
    styleChange (state) {
      state.styleChange = !state.styleChange;
    },
    speech (state, speech) {
      state.speech = speech;
    },
    timePassed (state, time) {
      state.timePassed = time;
    },
    reset (state) {
      state.nimi.id = '';
      state.nimi.current_time = '';
      state.nimi.food_today = '';
      state.nimi.food_eaten = '';
      state.nimi.food_progress = '';
      state.nimi.food_started = '';
      state.nimi.food_status = '';
      state.nimi.nimi_born = '';
      state.nimi.nimi_lastfed = '';
      state.nimi.nimi_name = '';
      state.nimi.nimi_points = '';
      state.nimi.nimi_position = '';
      state.nimi.nimi_state = '';
      state.nimi.nimi_meta = '';
      state.nimi.nimi_mood = '';
      state.nimi.nimi_temp = '';
      state.nimi.nimi_style.color1 = "#e4e4e4";
      state.nimi.nimi_style.color2 = "#FDFDFD";
      state.nimi.nimi_style.color3 = "#ffffff";
      state.nimi.nimi_style.skin_url = "undefined";
      state.nimi.nimi_style.x1 = "1";
      state.nimi.nimi_style.x2 = "0.8428121700606598";
      state.nimi.nimi_style.y1 = "1";
      state.nimi.nimi_style.y2 = "-0.11844952587765922";
      state.nimi.nimi_value = '';
      state.nimi.nimiq_address = '';
      state.nimi.nimi_price = '';
      state.nimi.nimi_msg = '';
      state.nimi.referral_id = '';
      state.nimi.referred_by = '';
      state.nimi.registered = '';
      state.nimi.user_id = '';
      state.items.food.burger = 0;
      state.items.food.water = 0;
      state.items.food.pepper = 0;
      state.items.food.durian = 0;
      state.items.food.peyote = 0;
      state.items.magic.resurrection = 0;
      state.items.magic.hibernation = 0;
      state.items.magic.sunglasses = 0;
      state.items.food.pills = 0;
    }
  },
  getters: {

  },
  actions: {

  }
})
