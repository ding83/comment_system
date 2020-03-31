<template>
    <div class="card my-4">
      <h5 class="card-header">Leave a Comment:</h5>
      <div class="card-body">
        <form onsubmit="return false;">
          <div class="form-group">
            Name:
            <input class="form-control" type="text" name="full_name">
          </div>
          <div class="form-group">
            Comment:
            <textarea class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
</template>
<script>
  export default {}
</script>