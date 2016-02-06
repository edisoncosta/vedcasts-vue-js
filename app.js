Vue.filter('dateFormat', function (value, formatString) {
    if (formatString != undefined) {
        return moment(value).format(formatString);
    }
    return moment(value).format('DD/MM/YYYY');
});

new Vue({
    el: '#beerApp',

    data: {
        cervejarias: {
            all: [],
            list: [],
        },
        pagination: {
            currentPage: 1,
            totalPages: 0,
            totalItems: 0,
            pageNumbers: []
        },
        interaction: {
            visibleColumns: ['name', 'last_mod'],
            columnsToFilter: [],
            filterTerm: '',
            openDetails: [],
            sortColumn: 'name',
            sortInverse: false
        },
        controls: {
            select2: null,
        },
    },

    methods: {
        doOpenDetails: function (ev, id) {

            ev.preventDefault();

            var self = this,

                index = self.interaction.openDetails.indexOf(id);

            if (index > -1) {
                self.interaction.openDetails.$remove(index);
            }
            else {
                self.interaction.openDetails.push(id);
            }
        },

        openAllDetails: function (ev) {
            ev.preventDefault();

            var self = this;

            if (self.interaction.openDetails.length > 0) {
                self.interaction.$set('openDetails', []);
            } else {
                self.interaction.$set('openDetails', _.pluck(self.cervejarias.list, 'id'));
            }
        },

        doSort: function (ev, column) {
            ev.preventDefault();

            var self = this;

            self.interaction.sortColumn = column;

            self.interaction.$set("sortInverse", !self.interaction.sortInverse);
        },

        doFilter: function (ev) {
            var self = this,

                filtered = self.cervejarias.all;

            if (self.interaction.filterTerm != '' && self.interaction.columnsToFilter.length > 0) {
                filtered = _.filter(self.cervejarias.all, function (cervejaria) {
                    return self.interaction.columnsToFilter.some(function (column) {
                        return cervejaria[column].toLowerCase().indexOf(self.interaction.filterTerm.toLowerCase()) > -1
                    });
                });
            }

            self.cervejarias.$set('list', filtered);
        },

        doResetAll: function (ev) {
            var self = this;

            self.interaction.$set('visibleColumns', ['name', 'last_mod']);
            self.interaction.$set('columnsToFilter', []);
            self.interaction.$set('filterTerm', '');
            self.cervejarias.$set('list', self.cervejarias.all);
            self.interaction.$set('openDetails', []);
            self.interaction.$set('sortColumn', 'name')
            self.interaction.$set('sortInverse', false);

            //Set Select empty value and fire event change
            self.controls.select2.val('').trigger('change');
        }
    },

    ready: function () {
        var self = this;

        self.$http.get('cervejarias.json').then(function (response) {
            self.cervejarias.$set('all', response.data);
            self.cervejarias.$set('list', response.data);
        });

        self.controls.select2 = $(self.$$.columnsToFilterSelect).select2({
            placeholder: 'Selecionar uma ou mais colunar para filtrar'
        }).on('change', function () {
            self.interaction.$set('columnsToFilter', $(this).val());
        });
    }
});