<template>
  <div class="container">
    <div class="columns is-centered">
     <div class="box columns">
       <div class="column is-3-tablet is-3-desktop is-3-widescreen is-centered">
         <figure class="image is-128x128">
           <img src="https://bulma.io/images/placeholders/128x128.png">
         </figure>
       </div>
       <div class="column is-9-tablet is-9-desktop is-9-widescreen pl-6">
         <form @submit.prevent="save()">
           <div class="field">
             <label for="firstName" class="label">First name</label>
             <div id="firstName" class="control has-icons-left">
               <input type="text"
                      v-model="formData.first_name"
                      placeholder="Enter first name"
                      class="input" />
               <span class="icon is-small is-left">
                  <i class="fa fa-user"></i>
                </span>
             </div>
           </div>
           <div class="field">
             <label for="secondName" class="label">Second name</label>
             <div id="secondName" class="control has-icons-left">
               <input type="text"
                      v-model="formData.second_name"
                      placeholder="Enter second name"
                      class="input" />
               <span class="icon is-small is-left">
                  <i class="fa fa-user"></i>
                </span>
             </div>
           </div>
           <div class="field">
             <label for="patronymic" class="label">Patronymic</label>
             <div id="patronymic" class="control has-icons-left">
               <input type="text"
                      v-model="formData.patronymic"
                      placeholder="Enter patronymic"
                      class="input" />
               <span class="icon is-small is-left">
                  <i class="fa fa-user"></i>
                </span>
             </div>
           </div>
           <div class="field">
             <label for="birthday" class="label">Birthday</label>
             <div id="birthday" class="control has-icons-left">
               <input type="date"
                      v-model="formData.birthday"
                      placeholder="Enter birthday"
                      class="input" />
               <span class="icon is-small is-left">
                  <i class="fa fa-calendar"></i>
                </span>
             </div>
           </div>
           <div class="field">
             <button class="button is-success" :disabled="loading">
               Save
             </button>
           </div>
         </form>
       </div>
     </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data () {
    return {
      loading: false,
      formData: {
        first_name: '',
        second_name: '',
        patronymic: '',
        birthday: null
      }
    }
  },
  mounted () {
    this.fillForm()
  },
  methods: {
    async save () {
      this.loading = true
      await this.$store.dispatch('updateUserProfile', this.formData)
      this.loading = false
    },
    fillForm () {
      this.formData = Object.assign(this.formData, this.$store.getters.user.credentials)
    }
  }
}
</script>

<style scoped>

</style>
