Vue.filter('dateFormat', function(value, formatString)
{
    if (formatString != undefined)
    {
        return moment(value).format(formatString);
    }
    return moment(value).format('DD/MM/YYYY');
});

new Vue({
    el: '#beerApp',

    data: {
        cervejarias: [],
        all: [],
        openDetails: [],
        sortColumn: 'name',
        sortInverse: false,
        filterTerm: ''
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

        },

        doFilter: function(ev) {
            var self = this;

            var filtered = self.all;

            if (self.filterTerm != '') {
                filtered = _.filter(self.all, function (cervejaria)
                {
                    return cervejaria.name.toLowerCase().indexOf(self.filterTerm.toLowerCase()) > -1
                });
            }
            self.$set('cervejarias', filtered);
        }
    },

    ready: function() {
        var self = this;
        //alert(this.$el.id);
        self.$http.get('cervejarias.json', function(response)
        {
            self.cervejarias = response;
            self.$set('all', self.cervejarias);
            //window.console.log(response);
        });
    }
});