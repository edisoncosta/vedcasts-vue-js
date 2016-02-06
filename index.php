<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Vue.js</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="/node_modules/select2/dist/css/select2.css"/>
</head>
<style>
    [v-cloak] {
        display: none;
    }
</style>
<body>
<div class="container" id="beerApp">

    <form v-on="submit:save">
        <div class="modal fade" v-el="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Gerenciamento Cervejaria</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <pre>{{ $data.cervejaria | json }}</pre> -->
                        <div class="form-group">
                            <label for="name">Nome Cervejaria</label>
                            <input type="text" v-model="cervejaria.name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="city">Cidade</label>
                            <input type="text" v-model="cervejaria.city" class="form-control" id="city">
                        </div>
                        <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" v-model="cervejaria.state" class="form-control" id="state">
                        </div>
                        <div class="form-group">
                            <label for="country">País</label>
                            <input type="text" v-model="cervejaria.country" class="form-control" id="country">
                        </div>
                        <div class="form-group">
                            <label for="descript">Descrição</label>
                            <input type="text" v-model="cervejaria.descript" class="form-control" id="descript">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>



    <h1>Bem vindo à série Vue.Js!</h1>

    <!--
    <div class="well">
    <pre>{{ [ $data.sortColumn, $data.sortInverse] | json }}</pre>
    </div>
    //-->


    <div class="row" v-cloak>
        <div class="col-md-2">
            <div class="well">
                <label>Colunas Visiveis</label>
                <select v-el="visibleColumns"
                        class="form-control"
                        v-model="interaction.visibleColumns"
                        multiple
                >
                    <option value="name">Nome</option>
                    <option value="city">Cidade</option>
                    <option value="state">Estado</option>
                    <option value="country">País</option>
                    <option value="last_mod">Data</option>
                </select>
            </div>
            <div class="well">
                <button type="button" v-on="click:doResetAll" class="btn btn-default btn-clock">
                    Reset Geral
                </button>
            </div>
            <div class="well">
                <button type="button" v-on="click:new" class="btn btn-primary btn-clock">
                    Nova Cervejaria
                </button>
            </div>
        </div>
        <div class="col-md-10">
            <div class="well">
                <div class="row">
                    <div class="col-md-6">
                        <input
                                type="text"
                                class="form-control"
                                v-model="interaction.filterTerm"
                                v-on="keyup:doFilter"
                                placeholder="Digite o termo para filtrar a lista"
                        />
                    </div>
                    <div class="col-md-6">
                        <select v-el="columnsToFilterSelect"
                                class="form-control"
                                v-model="interaction.columnsToFilter"
                                multiple
                        >
                            <option value="name">Nome</option>
                            <option value="city">Cidade</option>
                            <option value="state">Estado</option>
                            <option value="country">País</option>
                        </select>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th v-show="interaction.visibleColumns.indexOf('name') >  -1">
                        <a href="#" v-on="click:doSort($event, 'name')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:interaction.sortColumn == 'name' && interaction.sortInverse == false,
                        fa-sort-amount-desc:interaction.sortColumn == 'name' && interaction.sortInverse == true
                        "></i>
                            Nome
                        </a>
                    </th>
                    <th v-show="interaction.visibleColumns.indexOf('city') >  -1">
                        <a href="#" v-on="click:doSort($event, 'city')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:interaction.sortColumn == 'city' && interaction.sortInverse == false,
                        fa-sort-amount-desc:interaction.sortColumn == 'city' && interaction.sortInverse == true
                        "></i>
                            Cidade
                        </a>
                    </th>
                    <th v-show="interaction.visibleColumns.indexOf('state') >  -1">
                        <a href="#" v-on="click:doSort($event, 'state')">
                            <i class="fa fa-fw fa-sort" v-class="
                        fa-sort-amount-asc:interaction.sortColumn == 'state' && interaction.sortInverse == false,
                        fa-sort-amount-desc:interaction.sortColumn == 'state' && interaction.sortInverse == true
                        "></i>
                            Estado
                        </a>
                    </th>
                    <th v-show="interaction.visibleColumns.indexOf('country') >  -1">
                        <a href="#" v-on="click:doSort($event, 'country')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:interaction.sortColumn == 'country' && interaction.sortInverse == false,
                        fa-sort-amount-desc:interaction.sortColumn == 'country' && interaction.sortInverse == true
                        "></i>
                            País
                        </a>
                    </th>
                    <th v-show="interaction.visibleColumns.indexOf('last_mod') >  -1">
                        <a href="#" v-on="click:doSort($event, 'last_mod')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:interaction.sortColumn == 'last_mod' && interaction.sortInverse == false,
                        fa-sort-amount-desc:interaction.sortColumn == 'last_mod' && interaction.sortInverse == true
                        "></i>
                            Atualizado em
                        </a>
                    </th>
                    <th width="1%" nowrap>
                        <a href="#" v-on="click:openAllDetails">
                            <i class="fa"
                               v-class="fa-plus-square:interaction.openDetails.length == 0,
                                    fa-minus-square:interaction.openDetails.length > 0">
                            </i>
                        </a>
                    </th>
                    <th width="1%" nowrap>
                        <i class="fa fa-fw fa-edit"></i>
                    </th>
                </tr>
                </thead>
                <tbody v-repeat="cervejaria:cervejarias.list | orderBy interaction.sortColumn interaction.sortInverse">
                <tr>
                    <td v-show="interaction.visibleColumns.indexOf('name') >  -1">{{ cervejaria.name }}</td>
                    <td v-show="interaction.visibleColumns.indexOf('city') >  -1">{{ cervejaria.city }}</td>
                    <td v-show="interaction.visibleColumns.indexOf('state') >  -1">{{ cervejaria.state }}</td>
                    <td v-show="interaction.visibleColumns.indexOf('country') >  -1">{{ cervejaria.country }}</td>
                    <td v-show="interaction.visibleColumns.indexOf('last_mod') >  -1">{{ cervejaria.last_mod | dateFormat 'DD/MM/YYYY HH:mm:ss' }}</td>
                    <td>
                        <a href="#"
                           v-show="cervejaria.descript != ''"
                           v-on="click:doOpenDetails($event, cervejaria.id)">
                            <i class="fa"
                               v-class="fa-plus-square:interaction.openDetails.indexOf(cervejaria.id) == -1,
                                    fa-minus-square:interaction.openDetails.indexOf(cervejaria.id) > -1">
                            </i>
                        </a>
                        <i class="fa fa-plus-square"
                           v-show="cervejaria.descript == ''"
                           style="opacity: 0.3;"></i>
                    </td>
                    <td width="1%" nowrap>
                        <a href="#" v-on="click:edit($event, cervejaria)"><i class="fa fa-fw fa-edit"></i></a>
                    </td>
                </tr>
                <tr v-show="interaction.openDetails.indexOf(cervejaria.id) > -1 && cervejaria.descript != ''">
                    <td colspan="6">{{ cervejaria.descript }}</td>
                </tr>
                </tbody>
            </table>

            <nav class="text-center">
                <ul class="pagination">
                    <li
                        v-class="disabled:pagination.currentPage == 1">
                        <a href="#" aria-label="Previous" v-on="click:previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li
                        v-repeat="pagination.pageNumbers"
                        v-class="active:$value == pagination.currentPage">
                        <a href="#" v-on="click:page($event, $value)">{{ $value }}</a>
                    </li>
                    <li
                        v-class="disabled:pagination.currentPage == pagination.totalPages">
                        <a href="#" aria-label="Next" v-on="click:next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- <div class="well">
                    <pre>{{ $data.pagination | json }}</pre>
                </div> -->

        </div>
    </div>
</div>
<script src="/node_modules/jquery/dist/jquery.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="/node_modules/vue/dist/vue.js"></script>
<script src="/node_modules/vue-resource/dist/vue-resource.js"></script>
<script src="/node_modules/moment/moment.js"></script>
<script src="/node_modules/select2/dist/js/select2.full.js"></script>
<script src="lodash.js"></script>
<script src="app.js"></script>
</body>
</html>