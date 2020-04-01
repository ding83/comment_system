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
    setCommentLists(state, payload) {
      state.comments = payload
    },
    updateComments(state, payload) {
        Object.assign(state.comments, payload)
    }
  },
  actions: {
    fetchComments(context, payload) {
      let config = {
        method  : 'get',
        url     : `${baseUrl}/comments?post_id=${payload.post_id}`,
      };

      return new Promise((resolve, reject) => axios(config).then(response => resolve(response)).catch(error => reject(error)))
    },
    commentPost(state, payload) {
      let config = {
        method  : 'post',
        url     : `${baseUrl}/comments`,
        data    : payload
      };

      return new Promise((resolve, reject) => axios(config).then(response => resolve(response)).catch(error => reject(error)))
    }
  }
};