<template>
    <div v-if="article" class="alert alert-primary" role="alert" style="position: fixed; top: 20px; right: 20px; background: #7c3aed; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999;">
        Добавлена новая статья: <strong><a :href="'/articles/' + article.id" style="color: #fff; text-decoration: underline;">{{ article.name }}</a></strong>
        <button @click="article = null" style="margin-left: 15px; background: none; border: none; color: white; font-weight: bold; cursor: pointer;">✖</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: null
        };
    },
    created() {
        // Добавляем точку перед именем события, так как мы переопределили его в broadcastAs()
        window.Echo.channel('test').listen('.NewArticleEvent', (e) => {
            console.log('Событие поймано!', e);
            this.article = e.article;
        });
    }
}
</script>