<template>
  <div>
    <a class="btn btn-primary ml-4" v-on:click="followUser($event)">follow</a>
  </div>
</template> 

<script>
export default {
  name: "follow-button",
  data: function() {
    //state
    return {
      status: {}
    };
  },
  props: {
    userId: {
      type: String,
      required: true
    }
  },
  mounted() {
    console.log("Follow Component mounted.");
  },

  methods: {
    async followUser(e) {
      // console.log(this.userId);

      e.stopPropagation();
      try {
        const res = await axios.post(`/follow/${this.userId}`); //props: user-id

        console.log(res.data);
      } catch (err) {
        console.log(err);
        if (err.response.status == 401) window.location = "/login";
      }
    }
  }
};
</script>
