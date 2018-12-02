import dataStore from './dataStore.js'

export default {
  debug: true,
  state: {
    user: {},
    authenticated: false,
  },

  login (email, password, successCb = null, errorCb = null) {
    var login_param = {email: email, password: password}
    window.axios.post('/api/login', login_param).then(res => {
      this.state.user = res.data.user;
      this.state.authenticated = true;
      dataStore.initChart(res => {}, error => {});
      successCb();
    }).catch(error => errorCb());
  },

  setCurrentUser () {
    window.axios.get('/api/me').then(res => {
      this.state.user = res.data.user;
      this.state.authenticated = true;
      dataStore.initChart(res => {}, error => {});
    }).catch(error => {
      localStorage.removeItem('jwt-token');
    });
  },

  logout (successCb = null, errorCb = null) {
    window.axios.get('/api/logout').then(res => {
      localStorage.removeItem('jwt-token');
      this.state.authenticated = false;
      dataStore.currentDataInit();
      dataStore.storedChartInit();
      successCb();
    }).catch(error => errorCb());
  },

  signup (name, email, password, successCb = null, errorCb = null) {
    var signupParam = {name: name, email: email, password: password};
    window.axios.post('/api/signup', signupParam).then(res => {
      this.state.user = res.data.user;
      this.state.authenticated = true;
      successCb();
    }).catch(error => errorCb(error));
  },

  init () {
    if(localStorage.getItem('jwt-token')) {
      this.setCurrentUser();
    }
  }
}