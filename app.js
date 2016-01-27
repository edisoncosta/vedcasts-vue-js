new Vue({
    el: '#beerApp',

    data: {
        cervejarias: [],
        openDetails: [],
        sortColumn: 'name',
        sortInverse: false
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
        },

        openAllDetails: function(ev){
            ev.preventDefault();
            var self = this;

            //window.console.log(ids);
            if (self.openDetails.length > 0){
                self.$set('openDetails', []);
            } else {
                self.$set('openDetails', _.pluck(self.cervejarias, 'id'));
            }
        },

        doSort: function(ev, column) {
            ev.preventDefault();
            var self = this;

            self.sortColumn = column;

            self.$set("sortInverse", !self.sortInverse);

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