<template>
    <div class="card my-4">
      <h5 class="card-header">Leave a Comment:</h5>
      <div class="card-body">
        <form onsubmit="return false;">
          <div class="form-group">
            Name:
            <input class="form-control" type="text" name="full_name" v-model="name">
          </div>
          <div class="form-group">
            Comment:
            <textarea class="form-control" rows="3" v-model="comment"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" @click="submitComment()">Submit</button>
        </form>
      </div>
    </div>
</template>
<script>
  export default {
    props: ['post_id'],
    data() {
      return {
        name    : '',
        comment : '',
        parent_comment_id: null
      }
    },
    methods: {
      submitComment() {
        let data = {
          name    : this.name,
          comment : this.comment,
          post_id : this.post_id,
          parent_comment_id : this.parent_comment_id
        };

        this.$store.dispatch('commentPost', data).then(response => {
          console.log(response);
        }, error => {
            console.log(error.response.data);
        }).finally(() => {});

        this.$store.dispatch('fetchComments', {post_id: this.post_id}).then(response => {
          if (typeof response.data.data != 'undefined') {
            this.$store.commit('updateComments', response.data.data);
          }

          this.$parent.comments = response.data.data
        }, error => {
            console.log(error.response.data);
        }).finally(() => {
          this.name    = '';
          this.comment = '';
        });
      }
    }
  }
</script>