const state = {
  comments: []
};

export const comments = {
  state,
  getters: {
    getComments: state => {
        return state.comments;
    }
  },
  mutations: {
    updateComments(state, payload) {
        Object.assign(state.comments, payload)
    }
  }
};