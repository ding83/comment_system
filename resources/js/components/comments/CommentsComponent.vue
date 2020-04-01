<template>
    <div>
      <comment-form :post_id="post_id"></comment-form>      

      <!-- Modal -->
      <div class="modal fade" id="replyForm" tabindex="-1" role="dialog" aria-labelledby="replyFormTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Your Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Reply To: 
              <p>{{ replyTo.name }}</p>
              Message: 
              <p>{{ replyTo.comment }}</p>
              <form onsubmit="return false;">
                <div class="form-group">
                  Name:
                  <input class="form-control" type="text" name="full_name" v-model="name">
                </div>
                <div class="form-group">
                  Comment:
                  <textarea class="form-control" rows="3" v-model="comment"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" @click="submitReply()">Reply</button>
            </div>
          </div>
        </div>
      </div>


      <!-- Single Comment -->
      <div v-for="(comment, index) in comments" class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
          <h5 class="mt-0">{{ comment.name }}</h5>
          {{ comment.comment }}
          <div><a href="#" data-toggle="modal" data-target="#replyForm" @click="processReply(comment)">Reply</a></div>

          <div v-if="comment.children">

            <div v-for="(children, childIndex) in comment.children" class="media mt-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">{{ children.name }}</h5>
                {{ children.comment }}
                <div><a href="#" data-toggle="modal" data-target="#replyForm" @click="processReply(children)">Reply</a></div>

                <div v-if="children.children">
                  <div v-for="(grandchildren, grandChildIndex) in children.children" class="media mt-4">
                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                    <div class="media-body">
                      <h5 class="mt-0">{{ grandchildren.name }}</h5>
                      {{ grandchildren.comment }}
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  props: ['post_id'],
  data() {
    return {
      replyTo: {
        name: '',
        comment: '',
        post_id: '',
        parent_comment_id: null
      },
      name: '',
      comment: '',
      comments : []
    }
  },
  mounted() {
    this.getCommentsApi()
  },
  methods: {
    getCommentsApi() {
      this.$store.dispatch('fetchComments', {post_id: this.post_id}).then(response => {
        if (typeof response.data.data != 'undefined') {
          this.$store.commit('updateComments', response.data.data);
        }

        this.comments = this.$store.state.comments.comments;
      }, error => {
          console.log(error.response.data);
      }).finally(() => {});
    },
    processReply(comment) {
      this.replyTo.name = comment.name;
      this.replyTo.comment = comment.comment
      this.replyTo.post_id = comment.post_id;
      this.replyTo.comment_id = comment.comment_id;
      this.replyTo.parent_comment_id = comment.parent_comment_id;
    },
    submitReply() {
      $('#replyForm').modal('toggle');

      let data = {
        name    : this.name,
        comment : this.comment,
        post_id : this.replyTo.post_id,
        parent_comment_id : this.replyTo.comment_id
      }

      this.$store.dispatch('commentPost', data).then(response => {
        console.log(response);
      }, error => {
          console.log(error.response.data);
      }).finally(() => {});

      this.$store.dispatch('fetchComments', {post_id: this.post_id}).then(response => {
        if (typeof response.data.data != 'undefined') {
          this.$store.commit('updateComments', response.data.data);
        }

        this.comments = response.data.data
      }, error => {
          console.log(error.response.data);
      }).finally(() => {
        this.name    = '';
        this.comment = '';
        this.replyTo.name = '';
        this.replyTo.comment = '';
        this.replyTo.post_id = '';
        this.replyTo.parent_comment_id = '';
      });
    }
  }
}
</script>