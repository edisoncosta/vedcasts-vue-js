new Vue({
    el: '#beerApp',

    data: {
        cervejarias: []
    },

    ready: function() {
        var self = this;
        //alert(this.$el.id);
        self.$http.get('cervejarias.json', function(response)
        {
            self.cervejarias = response;
            window.console.log(response);
        });

    }
});