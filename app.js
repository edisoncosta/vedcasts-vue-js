new Vue({
    el: '#beerApp',

    data: {
        cervejarias: [],
        openDetails: []
    },

    methods: {
        doOpenDetails: function (ev, id) {
            //window.console.log(ev, id);
            ev.preventDefault();
            var self = this;

            var index = self.openDetails.indexOf(id);

            if (index > -1)
            {
                self.openDetails.$remove(index);
            } else {
                self.openDetails.push(id);
            }
        }
    },

    ready: function() {
        var self = this;
        //alert(this.$el.id);
        self.$http.get('cervejarias.json', function(response)
        {
            self.cervejarias = response;
            //window.console.log(response);
        });
    }
});