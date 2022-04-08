<template>
     <v-col cols="12" md="4" sm="6" >
      <div class="postBlock">
          <div class="postBlock--img">
              <Link :href="'/articles/'+data.slug"><img :src="data.header_image + '?tr=w-350,h-200'" :alt="data.title"></Link>
          </div>
          <div class="postBlock--content">
                <button class="text-white rounded-full" :class="'bg-'+tag.color+'-500'" v-for="tag in data.tags" :key="tag.id">
                  {{tag.name}}
                </button>
              <h3 class="postBlock--title"><Link :href="'/articles/'+data.slug"> {{data.title}}</Link></h3>
              <p>{{data.content.substring(0,250) | stripHTML}}</p>
              <div class="postPersonal--detail">
                <img src="/images/news-author-01.png" :alt="data.title">
                <p><a href="#">{{data.author_name}} </a> - {{new Date(data.publish_date).toDateString().slice(4,10)+','+new Date(data.publish_date).toDateString().slice(10)}}</p>
              </div>
          </div>
        </div>
    </v-col>

</template>

<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
         components: {
        Link
        },
        props: ['data'],
  }
</script>
