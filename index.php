<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Vue.js</title>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="/node_modules/select2/dist/css/select2.css"/>
</head>
<body>
<div class="container" id="beerApp">
    <h1>Bem vindo à série Vue.Js!</h1>

    <!--
    <div class="well">
    <pre>{{ [ $data.sortColumn, $data.sortInverse] | json }}</pre>
    </div>
    //-->


    <div class="row">
        <div class="col-md-2">
            <div class="well">
                <label>Colunas Visiveis</label>
                <select v-el="visibleColumns"
                        class="form-control"
                        v-model="visibleColumns"
                        multiple
                >
                    <option value="name">Nome</option>
                    <option value="city">Cidade</option>
                    <option value="state">Estado</option>
                    <option value="country">País</option>
                    <option value="last_mod">Data</option>
                </select>
            </div>
        </div>
        <div class="col-md-10">
            <div class="well">
                <div class="row">
                    <div class="col-md-6">
                        <input
                                type="text"
                                class="form-control"
                                v-model="filterTerm"
                                v-on="keyup:doFilter"
                                placeholder="Digite o termo para filtrar a lista"
                        />
                    </div>
                    <div class="col-md-6">
                        <select v-el="columnsToFilterSelect"
                                class="form-control"
                                v-model="columnsToFilter"
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
                    <th v-show="visibleColumns.indexOf('name') >  -1">
                        <a href="#" v-on="click:doSort($event, 'name')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:sortColumn == 'name' && sortInverse == false,
                        fa-sort-amount-desc:sortColumn == 'name' && sortInverse == true
                        "></i>
                            Nome
                        </a>
                    </th>
                    <th v-show="visibleColumns.indexOf('city') >  -1">
                        <a href="#" v-on="click:doSort($event, 'city')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:sortColumn == 'city' && sortInverse == false,
                        fa-sort-amount-desc:sortColumn == 'city' && sortInverse == true
                        "></i>
                            Cidade
                        </a>
                    </th>
                    <th v-show="visibleColumns.indexOf('state') >  -1">
                        <a href="#" v-on="click:doSort($event, 'state')">
                            <i class="fa fa-fw fa-sort" v-class="
                        fa-sort-amount-asc:sortColumn == 'state' && sortInverse == false,
                        fa-sort-amount-desc:sortColumn == 'state' && sortInverse == true
                        "></i>
                            Estado
                        </a>
                    </th>
                    <th v-show="visibleColumns.indexOf('country') >  -1">
                        <a href="#" v-on="click:doSort($event, 'country')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:sortColumn == 'country' && sortInverse == false,
                        fa-sort-amount-desc:sortColumn == 'country' && sortInverse == true
                        "></i>
                            País
                        </a>
                    </th>
                    <th v-show="visibleColumns.indexOf('last_mod') >  -1">
                        <a href="#" v-on="click:doSort($event, 'last_mod')">
                            <i class="fa fa-fw fa-sort"
                               v-class="
                        fa-sort-amount-asc:sortColumn == 'last_mod' && sortInverse == false,
                        fa-sort-amount-desc:sortColumn == 'last_mod' && sortInverse == true
                        "></i>
                            Atualizado em
                        </a>
                    </th>
                    <th width="1%" nowrap>
                        <a href="#" v-on="click:openAllDetails">
                            <i class="fa"
                               v-class="fa-plus-square:openDetails.length == 0,
                                    fa-minus-square:openDetails.length > 0">
                            </i>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody v-repeat="cervejaria:cervejarias | orderBy sortColumn sortInverse">
                <tr>
                    <td v-show="visibleColumns.indexOf('name') >  -1">{{ cervejaria.name }}</td>
                    <td v-show="visibleColumns.indexOf('city') >  -1">{{ cervejaria.city }}</td>
                    <td v-show="visibleColumns.indexOf('state') >  -1">{{ cervejaria.state }}</td>
                    <td v-show="visibleColumns.indexOf('country') >  -1">{{ cervejaria.country }}</td>
                    <td v-show="visibleColumns.indexOf('last_mod') >  -1">{{ cervejaria.last_mod | dateFormat 'DD/MM/YYYY HH:mm:ss' }}</td>
                    <td>
                        <a href="#"
                           v-show="cervejaria.descript != ''"
                           v-on="click:doOpenDetails($event, cervejaria.id)">
                            <i class="fa"
                               v-class="fa-plus-square:openDetails.indexOf(cervejaria.id) == -1,
                                    fa-minus-square:openDetails.indexOf(cervejaria.id) > -1">
                            </i>
                        </a>
                        <i class="fa fa-plus-square"
                           v-show="cervejaria.descript == ''"
                           style="opacity: 0.3;"></i>
                    </td>
                </tr>
                <tr v-show="openDetails.indexOf(cervejaria.id) > -1 && cervejaria.descript != ''">
                    <td colspan="6">{{ cervejaria.descript }}</td>
                </tr>
                </tbody>
            </table>

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