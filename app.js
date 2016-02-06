Vue.filter('dateFormat', function (value, formatString) {
    if (formatString != undefined) {
        return moment(value).format(formatString);
    }
    return moment(value).format('DD/MM/YYYY');
});

new Vue({
    el: '#beerApp',

    data: {
        cervejaria: {
            name: '',
            city: '',
            state: '',
            country: '',
            descript: ''
        },
        cervejarias: {
            all: [],
            list: [],
        },
        pagination: {
            perPage: 10,
            currentPage: 1,
            totalPages: 0,
            totalItems: 0,
            pageNumbers: [],
            visibleNumbers: 3,
            paginated: []
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

        page: function(ev, page)
        {
            ev.preventDefault();

            var self = this;

            self.pagination.$set('currentPage', page);
            self.cervejarias.$set('list', self.cervejarias.paginated[self.pagination.currentPage-1]);
        },

        next: function(ev)
        {
            ev.preventDefault();

            var self = this;

            if (self.pagination.currentPage == self.pagination.totalPages)
            {
                return false;
            }

            self.pagination.$set('currentPage', self.pagination.currentPage + 1);
            self.cervejarias.$set('list', self.cervejarias.paginated[self.pagination.currentPage-1]);
        },

        previous: function(ev)
        {
            ev.preventDefault();

            var self = this;

            if (self.pagination.currentPage == 1)
            {
                return false;
            }

            self.pagination.$set('currentPage', self.pagination.currentPage - 1);
            self.cervejarias.$set('list', self.cervejarias.paginated[self.pagination.currentPage-1]);
        },

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

            self.setPaginationData(filtered);
        },

        doResetAll: function (ev) {
            var self = this;

            self.interaction.$set('visibleColumns', ['name', 'last_mod']);
            self.interaction.$set('columnsToFilter', []);
            self.interaction.$set('filterTerm', '');

            self.interaction.$set('openDetails', []);
            self.interaction.$set('sortColumn', 'name')
            self.interaction.$set('sortInverse', false);

            //Set Select empty value and fire event change
            self.controls.select2.val('').trigger('change');
            self.setPaginationData(self.cervejarias.all);
        },

        setPaginationData: function(list)
        {
            var self = this,
               chunk = _.chunk(list, self.pagination.perPage);

            self.cervejarias.$set('paginated', chunk);
            self.cervejarias.$set('list'     , chunk[0]);
            self.pagination.$set('totalItems',  list.length);
            self.pagination.$set('totalPages',  Math.ceil(list.length / self.pagination.perPage));
            self.pagination.$set('pageNumbers', _.range(1, self.pagination.totalPages + 1));
            self.pagination.$set('currentPage', 1);
        },

        new: function(ev) {
            var self = this;
            self.cervejaria.name = '';
            self.cervejaria.city = '';
            self.cervejaria.state = '';
            self.cervejaria.country = '';
            self.cervejaria.descript = '';

            $(self.$$.modal).modal('show');
        },

        edit: function(ev, cervejaria) {
            ev.preventDefault();
            var self = this;

            self.cervejaria.name = cervejaria.name;
            self.cervejaria.city = cervejaria.city;
            self.cervejaria.state = cervejaria.state;
            self.cervejaria.country = cervejaria.country;
            self.cervejaria.descript = cervejaria.descript;

            $(self.$$.modal).modal('show');
        },

        save: function(ev) {
            ev.preventDefault();
            var self = this;
            // self.$http.post('url do servico', cervejaria, function(response)
            // {

            // });

            $(self.$$.modal).modal('hide');
            window.alert('Cervejaria salva, seu bebum!');
            window.console.log(JSON.stringify(self.cervejaria));
        }
    },

    ready: function () {
        var self = this;

        self.$http.get('cervejarias.json').then(function (response) {
            self.cervejarias.$set('all', response.data);
            self.setPaginationData(response.data);
        });

        self.controls.select2 = $(self.$$.columnsToFilterSelect).select2({
            placeholder: 'Selecionar uma ou mais colunar para filtrar'
        }).on('change', function () {
            self.interaction.$set('columnsToFilter', $(this).val());
        });
    }
});