<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Panel club
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<style>
  .panel-table .panel-body{
    padding:0;
  }

  .panel-table .panel-body .table-bordered{
    border-style: none;
    margin:0;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
      text-align:center;
      width: 100px;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
  .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
    border-right: 0px;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
  .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
    border-left: 0px;
  }

  .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
    border-bottom: 0px;
  }

  .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
    border-top: 0px;
  }

  .panel-table .panel-footer .pagination{
    margin:0;
  }

  /*
  used to vertically center elements, may need modification if you're not using default sizes.
  */
  .panel-table .panel-footer .col{
   line-height: 34px;
   height: 34px;
  }

  .panel-table .panel-heading .col h3{
   line-height: 30px;
   height: 30px;
  }

  .panel-table .panel-body .table-bordered > tbody > tr > td{
    line-height: 34px;
  }
</style>

    <template id="home">
      <div>
        <div class="d-grid gap-3" style="text-align:left;">
          <div class="bg-light border rounded-3">
            <form class="w-100 me-3" v-on:submit="searchInfo" novalidate>
                <div class="input-group">
                  <input v-model="search.query" id="wallet-q" type="text" class="form-control" aria-label="Text input with segmented dropdown button" />
                  <button style="width:126px;" type="submit" class="btn btn-outline-secondary">{{_autoT('search')}}</button>

                  <!--//
                  <button style="width:126px;" type="submit" class="btn btn-outline-secondary">{{search.mode.label}}</button>
                  <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li v-for="(a, b) in options.search"><a class="dropdown-item" @click="search.mode=a">{{a.label}}</a></li>
                    <li><hr class="dropdown-divider"></li>
                  </ul>
                  -->
                </div>
            </form>
          </div>
          <div :class="'alert alert-'+messageClass" role="alert" v-if="message!==null">{{message}}</div>
          <div class="clearfix"></div>
        </div>

        <div class="d-grid gap-3" style="grid-template-columns: 1fr 3fr;" v-if="wallet!==null">
          <div class="bg-light border rounded-3">
            <div class="card">
              <h5 class="card-header">
                {{_autoT('wallet')}}
              </h5>
              <div class="card-body" v-if="wallet!==null">
                <!-- // <h5 class="card-title">PUID | UID</h5> -->
                <!-- // <p class="card-text">{{wallet}}</p> -->
                <div class="list-author-widget-contacts">
                  <ul class="no-list-style">
                    <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_uid')}} :</span> <a style="cursor:pointer;"> ******{{ wallet.uid.substr(-4) }}</a></li>
                    <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_puid')}} :</span> <a style="cursor:pointer;"> ******{{ wallet.puid.substr(-4) }}</a></li>
                    <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_type')}} :</span> <a style="cursor:pointer;"> {{ _autoT('wallets_type_' + wallet.type) }} </a></li>
                    <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_status')}} :</span> <a style="cursor:pointer;"> {{ _autoT('wallets_status_' + wallet.status) }}</a></li>
                    <li>
                      <span><i class="fal fa-donate"></i> {{_autoT('wallets_balance')}}:</span>
                      <a style="cursor:pointer;">
                        <div class="claim-price-wdget fl-wrap">
                          <div class="claim-price-wdget-content fl-wrap">
                            <div class="pricerange fl-wrap">
                              ${{ wallet.balance.toLocaleString() }}
                            </div>
                            <!-- // <div class="claim-widget-link fl-wrap"><span>Own or work here?</span><a href="#">Claim Now!</a></div> -->
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-footer">
                <ul class="nav justify-content-end" v-if="wallet!==null">
                  <li class="nav-item">
                    <a class="nav-link" @click="addBalance">
                      <i class="fal fa-cart-plus"></i>
                      {{_autoT('wallets_add_balance')}}
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" @click="subtractBalance">
                      <i class="fal fa-donate"></i>
                      {{_autoT('wallets_subtract_balance')}}
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" @click="clearBalance">
                      <i class="fal fa-eraser"></i>
                      {{_autoT('wallets_clear_balance')}}
                    </a>
                  </li>
                </ul>
              </div>
            </div>

            <div class="clearfix"><br></div>

            <div class="card" v-if="membership!==null&&membership.id>0">
              <h5 class="card-header">{{_autoT('wallets_schedule')}}</h5>
              <div class="card-body" v-if="membership!==null">
                <div class="">
                  <div class="box-widget opening-hours fl-wrap">
                    <div class="">
                      <ul class="no-list-style">
                        <li v-for="(day_lang, day) in $root.translate_days" :class="$root.translate_days_min[day]">
                          <span class="opening-hours-day"> {{_autoT(day)}} </span>
                          <span class="opening-hours-time" v-for="(item_day, item_day_i) in membership.day_schedule[day]">
                            <ul class="no-list-style facilities-list">
                              <li class=" tolt-title" :title="_autoT('location_feature_'+item_day.feature.id)" :data-tippy-content="_autoT('location_feature_'+item_day.feature.id)">
                                <span class="fa-stack" style="zoom:0.8">
                                  <i :class="item_day.feature.icon+' fa-stack-1x'" style="font-size:24px;"></i>
                                  <i :class="$root.translate_slugs_icons[item_day.type]+' fa-stack-2x'" style="color:steelblue;color:Tomatos;margin-top: -12px;margin-left: 12px;font-size:small;"></i>
                                  <i :class="item_day.feature.location.icon+' fa-stack-2x'" style="margin-left: 13px;margin-top: 13px;font-size: 10px;color: azure;background: steelblue;width: 16px;height: 16px;border-radius: calc(100%);padding: 3px 2px;font-weight: 900;"></i>
                                  <i v-if="item_day.req_reservation" class="fa fa-clock fa-stack-2x" style="margin-left: 0px;margin-top: -12px;font-size: 9.5px;color: azure;background: steelblue;width: 12px;height: 12px;border-radius: calc(100%);padding: 1px 2px;"></i>
                                </span>
                              </li>
                            </ul>
                          </span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
              </div>
            </div>
          </div>
          <div class="d-grid gap-3" style="grid-template-columns: 1fr;">
            <div class="d-grid gap-3" style="grid-template-columns: 1fr 1fr;">
              <div class="card">
                <h5 class="card-header">{{_autoT('wallets_owner')}}</h5>
                <div class="card-body">
                  <div v-if="user!==null && user.id !== undefined && user.id > 0">
                    <div class="list-author-widget-contacts">
                      <ul class="no-list-style">
                        <li><span><i class="fal fa-phone"></i> {{_autoT('users_display_name')}} :</span> <a style="cursor:pointer;"> {{ user.display_name }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('users_username')}} :</span> <a style="cursor:pointer;"> {{ user.username }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('users_email')}} :</span> <a style="cursor:pointer;"> {{ user.email }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('users_phones')}} :</span> <a style="cursor:pointer;"> {{ user.phones }}</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="list-author-widget-contacts" v-else>
                    <h5>{{_autoT('membership_expired')}}</h5>
                  </div>
                </div>
                <div class="card-footer">
                  <ul class="nav justify-content-end">
                    <li class="nav-item" v-if="wallet!==null&&wallet.user_id!==null">
                      <a class="nav-link" @click="clearUser">
                        <i class="fal fa-user-minus"></i>
                        {{_autoT('wallet_remove_owner')}}
                      </a>
                    </li>
                    <li class="nav-item" v-else-if="wallet!==null&&wallet.user_id==null">
                      <a class="nav-link" @click="addUser">
                        <i class="fal fa-user-plus"></i>
                        {{_autoT('wallet_assign_owner')}}
                      </a>
                    </li>
                  </ul>
                  <select class="form-control js-search-basic-single" name="user_selected" v-if="active_selecter_user==true">
                    <option v-for="(user, user_i) in options.users" :value="user.id">
                      {{user.username}} - {{user.display_name}} - {{user.email}}
                    </option>
                  </select>
                </div>
              </div>

              <div class="card">
                <h5 class="card-header">{{_autoT('membership')}}</h5>
                <div class="card-body">
                  <template v-if="membership!==null&&membership.id>0">
                    <div class="list-author-widget-contacts">
                      <ul class="no-list-style">
                        <li><span><i class="fal fa-phone"></i> {{_autoT('membership')}} :</span> <a style="cursor:pointer;"> {{ _autoT('membership_'+membership.membership.id) }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('memberships_max_members')}} :</span> <a style="cursor:pointer;"> {{ membership.max_members }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('memberships_status')}} :</span> <a style="cursor:pointer;"> {{ _autoT('memberships_status_'+membership.status) }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('memberships_startdate')}} :</span> <a style="cursor:pointer;"> {{ membership.startdate }}</a></li>
                        <li><span><i class="fal fa-phone"></i> {{_autoT('memberships_enddate')}} :</span> <a style="cursor:pointer;"> {{ membership.enddate }}</a></li>
                        <li>
                          <span><i class="fal fa-donate"></i> {{_autoT('balance_total')}} :</span>
                          <a style="cursor:pointer;">
                            <div class="claim-price-wdget fl-wrap">
                              <div class="claim-price-wdget-content fl-wrap">
                                <div class="pricerange fl-wrap">
                                  ${{ membership.balance_total.toLocaleString() }}
                                </div>
                                <!-- // <div class="claim-widget-link fl-wrap"><span>Own or work here?</span><a href="#">Claim Now!</a></div> -->
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </template>
                  <template v-else>
                    <h5>{{_autoT('membership_expired')}}</h5>
                  </template>
                </div>
                <div class="card-footer">
                  <ul class="nav justify-content-end">
                    <li class="nav-item" v-if="membership!==null&&membership.id>0">
                      <a class="nav-link" @click="endMembership">
                        <i class="fal fa-donate"></i>
                        {{_autoT('membership_end')}}
                      </a>
                    </li>
                    <li class="nav-item"  v-if="user!==null&&user.id>0&&membership.id==0">
                      <a class="nav-link" @click="addMembership">
                        <i class="fal fa-donate"></i>
                        {{_autoT('membership_start')}}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="d-grid gap-3" style="grid-template-columns: 1fr 2fr;" v-if="membership!==null&&membership.id>0">
              <div class="bg-light border rounded-3">
                <div class="card">
                  <h5 class="card-header">{{_autoT('more_wallets_users')}}</h5>
                </div>
                <template v-if="wallets!==null">
                  <div class="card" v-for="(o_w, o_w_i) in wallets" style="zoom:0.9;" v-if="o_w.uid !== search.query">
                    <h5 class="card-header">{{ o_w.alias }}</h5>
                    <div class="card-body">
                      <div class="list-author-widget-contacts">
                        <ul class="no-list-style">
                          <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_uid')}} :</span> <a @click="search.query=o_w.uid;searchInfo();" style="cursor:pointer;"> ******{{ o_w.uid.substr(-4) }}</a></li>
                          <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_puid')}} :</span> <a @click="search.query=o_w.uid;searchInfo();" style="cursor:pointer;"> ******{{ o_w.puid.substr(-4) }}</a></li>
                          <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_type')}} :</span> <a style="cursor:pointer;"> {{ _autoT('wallets_type_' + o_w.type) }} </a></li>
                          <li><span><i class="fa fa-donate"></i> {{_autoT('wallets_status')}} :</span> <a style="cursor:pointer;"> {{ _autoT('wallets_status_' + o_w.status) }}</a></li>
                          <li>
                            <span><i class="fal fa-donate"></i> {{_autoT('wallets_balance')}}:</span>
                            <a style="cursor:pointer;">
                              <div class="claim-price-wdget fl-wrap">
                                <div class="claim-price-wdget-content fl-wrap">
                                  <div class="pricerange fl-wrap">
                                    ${{ o_w.balance.toLocaleString() }}
                                  </div>
                                  <!-- // <div class="claim-widget-link fl-wrap"><span>Own or work here?</span><a href="#">Claim Now!</a></div> -->
                                </div>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </template>
              </div>

              <div class="card">
                <h5 class="card-header">{{_autoT('beneficiaries')}}</h5>
                <div class="card-body" v-if="membership!==null&&membership.id>0">
                  <div class="box-widget-author fl-wrap" v-for="(beneficiary, beneficiary_i) in membership.beneficiaries">
                    <div class="box-widget-author-title">
                      <div class="box-widget-author-title_content">
                          <a href="#">{{ beneficiary.names }} {{ beneficiary.surname }}</a>
                          <span>{{options.types_identifications.find(a=>a.id == beneficiary.identification_type).code}} . {{ beneficiary.identification_number }}</span>
                          <span>{{_autoT('beneficiaries_status_'+beneficiary.status)}}</span>
                      </div>
                      <div class="box-widget-author-title_opt">
                          <a @click="beneficiary_selected=beneficiary_i" class="color-bg cwb" data-bs-toggle="modal" data-bs-target="#modal-view-beneficiary">
                            <i v-if="beneficiary.status == 'authorized'" class="fal fa-eye"></i>
                            <i v-else class="fas fa-times"></i>
                          </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="d-grid gap-3" style="grid-template-columns: 1fr;" v-if="membership!==null&&membership.id>0">
              <div class="card">
                <h5 class="card-header">{{_autoT('membership_available')}}</h5>
                <div class="card-body table-responsive" v-if="membership!==null&&membership.id>0">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col" colspan="2">{{_autoT('memberships_benefit')}}</th>
                        <th scope="col" colspan="2">{{_autoT('memberships_limit_date')}}</th>
                        <th scope="col" colspan="1"></th>
                        <th scope="col" colspan="2">{{_autoT('memberships_count')}}</th>
                        <th scope="col" colspan="4">{{_autoT('memberships_available_vs_limit')}}</th>
                      </tr>
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">{{_autoT('benefits_name')}}</th>
                        <th scope="col">{{_autoT('benefits_days')}}</th>
                        <th scope="col">{{_autoT('benefits_months')}}</th>
                        <th scope="col">{{_autoT('benefits_req_reservation')}}</th>
                        <th scope="col">{{_autoT('benefits_limit_day')}}</th>
                        <th scope="col">{{_autoT('benefits_limit_week')}}</th>
                        <th scope="col">{{_autoT('benefits_limit_month')}}</th>
                        <th scope="col">{{_autoT('benefits_limit_year')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <template class="box-widget-item fl-wrap block_box" v-for="(include, include_i) in membership.benefits">
                        <tr>
                          <th>
                            <span class="tolt3" :title="_autoT(include.type)">
                              <i :class="$root.translate_slugs_icons[include.type]"></i>
                            </span>
                          </th>
                          <td>
                            <!--//
                              <a href="#">
                                <i :class="include.feature.location.icon"></i>
                                {{include.feature.location.name}}
                              </a>
                              <a href="#">
                                <i :class="include.feature.icon"></i>
                                {{include.feature.name}}
                              </a>
                            -->
                            {{_autoT('location_feature_'+include.feature.id)}} &nbsp;
                          </td>
                          <td>
                            <ul v-if="include.days!==null&&include.days.length>4" class="no-list-style facilities-list">
                              <li v-for="(d,d_i) in include.days.split(',')" :key="d_i">{{_autoT(d)}}</li>
                            </ul>
                            <p v-else>
                              {{_autoT('any_day')}} &nbsp;
                            </p>
                          </td>
                          <td>
                            <ul v-if="include.months!==null&&include.months.length>4" class="no-list-style">
                              <li v-for="(d,d_i) in include.months.split(',')" :key="d_i">{{_autoT(d)}}</li>
                            </ul>
                            <template v-else>
                              {{_autoT('any_month')}} &nbsp;
                            </template>
                          </td>
                          <td>
                            <template v-if="include.req_reservation>=1">
                              <i class="fal fa-check"></i> {{_autoT('req_reservation')}} {{include.req_reservation}}
                            </template>
                            <template v-else>
                              {{_autoT('not_req_reservation')}}	&nbsp;
                            </template>
                          </td>
                          <td>
                            <template v-if="include.limit_day!==null">
                              {{ include.available_day }} / {{ include.limit_day }}
                            </template>
                            <template v-else>
                              {{_autoT('Unlimited')}}	&nbsp;
                            </template>
                          </td>
                          <td>
                            <template v-if="include.limit_week!==null">
                              {{ include.available_week }} / {{ include.limit_week }}
                            </template>
                            <template v-else>
                              {{_autoT('Unlimited')}} 	&nbsp;
                            </template>
                          </td>
                          <td>
                            <template v-if="include.limit_month!==null">
                              {{ include.available_month }} / {{ include.limit_month }}
                            </template>
                            <template v-else>
                              {{_autoT('Unlimited')}} 	&nbsp;
                            </template>
                          </td>
                          <td>
                            <template v-if="include.limit_year!==null">
                              {{ include.available_year }} / {{ include.limit_year }}
                            </template>
                            <template v-else>
                              {{_autoT('Unlimited')}} 	&nbsp;
                            </template>
                          </td>
                        </tr>
                      </template>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p v-else>{{_autoT('load_the_information')}}</p>

        <!-- Modal view beneficiary -->
        <div class="modal fade" id="modal-view-beneficiary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <!--//<h5 class="modal-title" id="exampleModalLabel">Modal title : </h5>-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" v-if="wallet!==null&&membership!==null&&membership.beneficiaries!==null">
                <template v-if="beneficiary_selected !== null">
                  <div class="">
                    <div class="booking-list">
                      <div class="booking-list-message">
                        <div class="booking-list-message-text">
                          <h4>{{ membership.beneficiaries[beneficiary_selected].names }} {{ membership.beneficiaries[beneficiary_selected].surname }} - <span>27 December 2019</span></h4>
                          <!--//
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_identification_type')}}:</span>
                            <span class="booking-text">  </span>
                          </div>
                          -->
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_mobile')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].mobile }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_address')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].address }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_country')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].country }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_email')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].email }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_arp')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].arp }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_blood')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].blood_type }} {{ membership.beneficiaries[beneficiary_selected].blood_rh }}  </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_contact_emergency')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].emergency_contact }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_phone_emergency')}}:</span>
                            <span class="booking-text"> {{ membership.beneficiaries[beneficiary_selected].emergency_phone }} </span>
                          </div>
                          <div class="booking-details fl-wrap">
                            <span class="booking-title">{{_autoT('beneficiaries_status')}}:</span>
                            <span class="booking-text">
                              {{_autoT('beneficiaries_status_' + membership.beneficiaries[beneficiary_selected].status)}}
                              <!--//<strong class="done-paid">Autorizado  </strong> para disfrutar-->
                            </span>
                          </div>
                          <span class="fw-separator"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!--//<button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template id="pacmec-menu-api-component">
      <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">
        <li>
          <router-link tag="a" :to="{name:'Home'}" class="dropdown-item">
            Consulta rápida
          </router-link>
        </li>
        <li v-if="subjects!==null">
          <router-link tag="a" v-for="subject in subjects" v-bind:to="{name: 'List', params: {subject: subject.name}}" class="dropdown-item" :key="subject.name">
            {{ _autoT(subject.name) }}
          </router-link>
        </li>
        <!--//
        <li><a class="dropdown-item" href="#">Membresía</a></li>
        <li><a class="dropdown-item" href="#">Propietario</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Leer Monedero</a></li>
        <li><a class="dropdown-item" href="#">Cobrar</a></li>
        <li><a class="dropdown-item" href="#">Recargar Monedero</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Usuarios</a></li>
        -->
      </ul>
    </template>

    <template id="list">
      <div class="container">
        <div class="row">
          <h1>{{ _autoT(subject) }}</h1>
          <p>A simple example of how-to put a bordered table within a panel. Responsive, place holders in header/footer for buttons or pagination.</p>
          <p>Follow me <a href="https://twitter.com/asked_io" target="_new">@asked_io</a> & <a href="https://asked.io/" target="_new">asked.io</a>.</p>
          <p> </p>
          <p> </p>
          <div class="col-md-12">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title">{{_autoT('columns')}}</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                      <router-link class="btn btn-sm btn-primary btn-create" v-bind:to="{name: 'Add', params: {subject: subject}}">
                        {{ _autoT('add_record') }}
                      </router-link>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="card bg-light" v-if="field">
                  <div class="card-body">
                    <div style="float:right;"><router-link v-bind:to="{name: 'List', params: {subject: subject}}">Clear filter</router-link></div>
                    <p class="card-text">Filtered by: {{ field }} = {{ id }}</p>
                  </div>
                </div>
                <p v-if="records===null">{{ _autoT('loading') }}</p>
                <div v-else class="table-responsive">
                  <table class="table table-striped table-bordered table-list">
                    <thead>
                      <tr>
                        <th v-for="value in Object.keys(properties)">{{ _autoT(subject+'_'+value) }}</th>
                        <th v-if="related">related</th>
                        <th v-if="primaryKey">actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="record in records">
                        <template v-for="(value, key) in record">
                          <td v-if="references[key] !== false">
                            <router-link v-bind:to="{name: 'View', params: {subject: references[key], id: referenceId(references[key], record[key])}}">{{ referenceText(references[key], record[key]) }}</router-link>
                          </td>
                          <td v-else>{{ value }}</td>
                        </template>
                        <td v-if="related">
                          <template v-for="(relation, i) in referenced">
                            <router-link v-bind:to="{name: 'Filter', params: {subject: relation[0], field: relation[1], id: record[primaryKey]}}">{{ _autoT(relation[0]) }}</router-link>&nbsp;
                          </template>
                        </td>
                        <td v-if="primaryKey" style="padding: 6px; white-space: nowrap;">
                          <router-link class="btn btn-secondary btn-sm" v-bind:to="{name: 'View', params: {subject: subject, id: record[primaryKey]}}">{{_autoT('view_record')}}</router-link>
                          <router-link class="btn btn-secondary btn-sm" v-bind:to="{name: 'Edit', params: {subject: subject, id: record[primaryKey]}}">{{_autoT('edit_record')}}</router-link>
                          <router-link class="btn btn-danger btn-sm" v-bind:to="{name: 'Delete', params: {subject: subject, id: record[primaryKey]}}">{{_autoT('delete_record')}}</router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel-footer">
                <div class="row">
                  <div class="col col-xs-4">{{_autoT('page_records')}} 1 {{_autoT('page_records_of')}} 5
                  </div>
                  <div class="col col-xs-8">
                    <ul class="pagination hidden-xs pull-right">
                      <li><a href="#">«</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                      <li><a href="#">»</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>

      </div>
    </template>

    <template id="create">
      <div class="container">
        <h2>{{ subject }} - add</h2>
        <form v-on:submit="createRecord">
          <template v-for="(value, key) in record">
            <div class="form-group">
              <label v-bind:for="key">{{ key }}</label>
              <input v-if="references[key] === false" class="form-control" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" />
              <select v-else class="form-control" v-bind:id="key" v-model="record[key]">
                <option value=""></option>
                <option v-for="option in options[references[key]]" v-bind:value="option.key">{{ option.value }}</option>
              </select>
            </div>
          </template>
          <button type="submit" class="btn btn-primary">Create</button>
          <router-link class="btn btn-primary" v-bind:to="{name: 'List', params: {subject: subject}}">Cancel</router-link>
        </form>
      </div>
    </template>

    <template id="view">
      <div class="container">
        <h2>{{ subject }} - view</h2>
        <p v-if="record===null">Loading...</p>
        <div class="form" v-else>
          <div class="mb-3" v-for="(value, key) in record">
            <label :for="key" class="form-label">{{ key }}</label>
            <input type="text" class="form-control" :id="key" :placeholder="key" :value="value" readonly="" />
          </div>
        </div>
      </div>
    </template>

    <template id="update">
      <div class="container">
        <h2>{{ subject }} - edit</h2>
        <p v-if="record===null">Loading...</p>
        <form v-else v-on:submit="updateRecord">
          <template v-for="(value, key) in record">
            <div class="form-group">
              <label v-bind:for="key">{{ key }}</label>
              <input v-if="references[key] === false" class="form-control" v-bind:id="key" v-model="record[key]" :disabled="key === primaryKey" />
              <select v-else-if="!options[references[key]]" class="form-control" disabled>
                <option value="" selected>Loading...</option>
              </select>
              <select v-else class="form-control" v-bind:id="key" v-model="record[key]">
                <option value=""></option>
                <option v-for="option in options[references[key]]" v-bind:value="option.key">{{ option.value }}</option>
              </select>
            </div>
          </template>
          <button type="submit" class="btn btn-primary">Save</button>
          <router-link class="btn btn-secondary" v-bind:to="{name: 'List', params: {subject: subject}}">Cancel</router-link>
        </form>
      </div>
    </template>

    <template id="delete">
      <div class="container">
        <h2>{{ subject }} delete #{{ id }}</h2>
        <form v-on:submit="deleteRecord">
          <p>The action cannot be undone.</p>
          <button type="submit" class="btn btn-danger">Delete</button>
          <router-link class="btn btn-secondary" v-bind:to="{name: 'List', params: {subject: subject}}">Cancel</router-link>
        </form>
      </div>
    </template>

    <?php pacmec_foot(); ?>

    <script>
      var util = {
        methods: {
          resolve: function (path, obj) {
            return path.reduce(function(prev, curr) {
              return prev ? prev[curr] : undefined
            }, obj || this);
          },
          getDisplayColumn: function (columns) {
            var index = -1;
            var names = ['name', 'title', 'description', 'display_name', 'username'];
            for (var i in names) {
              index = columns.indexOf(names[i]);
              if (index >= 0) {
                return names[i];
              }
            }
            return columns[0];
          },
          getPrimaryKey: function (properties) {
            for (var key in properties) {
              if (properties[key]['x-primary-key']) {
                return key;
              }
            }
            return false;
          },
          getReferenced: function (properties) {
            var referenced = [];
            for (var key in properties) {
              if (properties[key]['x-referenced']) {
                for (var i = 0; i < properties[key]['x-referenced'].length; i++) {
                  referenced.push(properties[key]['x-referenced'][i].split('.'));
                }
              }
            }
            return referenced;
          },
          getReferences: function (properties) {
            var references = {};
            for (var key in properties) {
              if (properties[key]['x-references']) {
                references[key] = properties[key]['x-references'];
              } else {
                references[key] = false;
              }
            }
            return references;
          },
          getProperties: function (action, subject, definition) {
            if (action == 'list') {
              path = ['components', 'schemas', action + '-' + subject, 'properties', 'records', 'items', 'properties'];
            } else {
              path = ['components', 'schemas', action + '-' + subject, 'properties'];
            }
            return this.resolve(path, definition);
          }
        }
      };

      var orm = {
        methods: {
          readRecord: function () {
            this.id = this.$route.params.id;
            this.subject = this.$route.params.subject;
            this.record = null;
            var self = this;
            PACMEC.api.get('/records/' + this.subject + '/' + this.id).then(function (response) {
              self.record = response.data;
            }).catch(function (error) {
              console.log(error);
            });
          },
          readRecords: function () {
            this.subject = this.$route.params.subject;
            this.records = null;
            var url = '/records/' + this.subject;
            var params = [];
            for (var i=0;i<this.join.length;i++) {
              params.push('join='+this.join[i]);
            }
            if (this.field) {
              params.push('filter='+this.field+',eq,'+this.id);
            }
            if (params.length>0) {
              url += '?'+params.join('&');
            }
            var self = this;
            PACMEC.api.get(url).then(function (response) {
              self.records = response.data.records;
            }).catch(function (error) {
              console.log(error);
            });
          },
          readOptions: function() {
            this.options = {};
            var self = this;
            for (var key in this.references) {
              var subject = this.references[key];
              if (subject !== false) {
                var properties = this.getProperties('list', subject, this.definition);
                var displayColumn = this.getDisplayColumn(Object.keys(properties));
                var primaryKey = this.getPrimaryKey(properties);
                PACMEC.api.get('/records/' + subject + '?include=' + primaryKey + ',' + displayColumn).then(function (subject, primaryKey, displayColumn, response) {
                  self.options[subject] = response.data.records.map(function (record) {
                    return {key: record[primaryKey], value: record[displayColumn]};
                  });
                  self.$forceUpdate();
                }.bind(null, subject, primaryKey, displayColumn)).catch(function (error) {
                  console.log(error);
                });
              }
            }
          },
          updateRecord: function () {
            PACMEC.api.put('/records/' + this.subject + '/' + this.id, this.record).then(function (response) {
              console.log(response.data);
            }).catch(function (error) {
              console.log(error);
            });
            router.push({name: 'List', params: {subject: this.subject}});
          },
          initRecord: function () {
            this.record = {};
            for (var key in this.properties) {
              if (!this.properties[key]['x-primary-key']) {
                if (this.properties[key].default) {
                  this.record[key] = this.properties[key].default;
                } else {
                  this.record[key] = '';
                }
              }
            }
          },
          createRecord: function() {
            var self = this;
            PACMEC.api.post('/records/' + this.subject, this.record).then(function (response) {
              self.record.id = response.data;
            }).catch(function (error) {
              console.log(error);
            });
            router.push({name: 'List', params: {subject: this.subject}});
          },
          deleteRecord: function () {
            PACMEC.api.delete('/records/' + this.subject + '/' + this.id).then(function (response) {
              console.log(response.data);
            }).catch(function (error) {
              console.log(error);
            });
            router.push({name: 'List', params: {subject: this.subject}});
          }
        }
      };

      var pacmec_globals = {
        methods: {
          _autoT(field_slug){
            return this.$root.translateField(field_slug);
          }
        }
      };

      const Home = Vue.extend({
        mixins: [pacmec_globals],
      	template: '#home',
      	data(){
      		return {
      			messageClass: null,
      			message: null,
            active_selecter_user: false,
            beneficiary_selected: null,
      			search_q: '',
      			wallets: null,
      			wallet: null,
      			wallet_history: null,
      			membership: null,
      			user: null,
      			options: {
              includes: [
                'wallet',
                'membership',
                'user',
                'wallets',
                'wallet_history'
              ],
      				users: [],
      				memberships: [],
      				types_identifications: [],
              search: [
                {
                  "column": "uid",
                  "label": "reader_rfid"
                },
                {
                  "column": "uid",
                  "label": "UID"
                },
                {
                  "column": "puid",
                  "label": "PUID"
                },
              ],
            },
            search: {
              query: '',
              mode: {
                "column": "uid",
                "label": "reader_rfid"
              },
            },
      		};
      	},
      	mounted(){
      		let self = this;
          var myModalEl = document.getElementById('modal-view-beneficiary')
          myModalEl.addEventListener('hidden.bs.modal', function (event) {
            self.beneficiary_selected = null;
          })

      		self.loadOptions(); // Cargar Membresías
      		$("#wallet-q").focus();
      	},
      	methods: {
          searchInfo(){
            let self = this;
            self.messageClass = null;
            self.message      = null;
            self.wallet       = null;
            self.membership   = null;
            self.user         = null;
            self.wallets      = null;
            let searching = {...self.search};
            if(searching.query.length>=8){
              /**
              * Cargar Info
              */
              PACMEC.api.get("/", {
      					params: {
      						cmrfid: 'functions',
      						action: 'tag-info',
      						includes: self.options.includes.join(','),
      						tag_id: searching.query,
      					}
      				})
      				.then((a) => {
      					r = a.data;
      					if(a.data.message !== undefined){ self.message = self._autoT(a.data.message); self.messageClass = "danger"; }
      					if(a.data.error !== undefined && a.data.error == false){
      						r = a.data;
                  if(r.user) self.user = r.user;
                  if(r.wallet) self.wallet = r.wallet;
                  if(r.membership) self.membership = r.membership;
                  if(r.wallets) self.wallets = r.wallets;
                  self.messageClass = "success";
                  self.message = self._autoT("result_success");
      					}
      				})
      				.catch((e) => {
      					console.log('error', e);
                //self.message =
      				})
      				.finally(()=>{
                tippy('.tolt', {
            			animation: 'scale',
            			arrow: false
            		});
                $("#wallet-q").val("");
      					$("#wallet-q").focus();

                setTimeout(function () {
                  tippy(document.querySelectorAll('.tolt-title'));
                }, 500);
      				});
            }
          },
      		loadOptions(){
      			let self = this;
            PACMEC.list('users', {
            }, (a)=>{
              if(a.error == false){
                self.options.users = a.response;

              }
            });
            PACMEC.list('memberships', {
            }, (a)=>{
              if(a.error == false){
                self.options.memberships = a.response;
              }
            });
            PACMEC.list('types_identifications', {
            }, (a)=>{
              if(a.error == false){
                self.options.types_identifications = a.response;

                /*
                self.options.types_identifications = a.response.map( b => {
                  return {};
                } );*/
              }
            });
            /*
      			PACMEC.read('/pacmec_cmrfid_memberships', {}, a => {
      				if(a.error == false){
      					self.options.memberships = a.response;
      				}
      			});*/
      		},
          clearUser(){
      			let self = this;
      			var dialog = bootbox.dialog({
      				title: 'Cerrando Membresía',
      				centerVertical: true,
      				message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>'
      			});
      			let params = {
      				cmrfid: 'functions',
      				action: 'clearing-user',
      				user: self.user.id,
      				wallet_uid: self.wallet.uid,
      				wallet_pin: self.wallet.pin,
      			};
      			dialog.init(function(){
      				PACMEC.api.get("", {
      					params: params
      				})
      				.then((r) => {
      					let result = r.data;
      					if(typeof result === 'object' && result !== null && result.message !== null){
      						dialog.find('.bootbox-body').html(self._autoT(result.message));
      					} else {
      						dialog.find('.bootbox-body').html("Ocurrio un error interno, comuniquese con soporte.");
      					}
      				})
      				.catch((e) => {
      					dialog.find('.bootbox-body').html('Ups error.!');
      				})
      				.finally(() => {
      					self.search.query  = self.wallet.uid;
                $("#wallet-q").focus();
      					self.searchInfo();
      					setTimeout(function(){
      						dialog.modal('hide');
      					}, 1750);
      				});
      			});
      		},
          addUser(){
      			let self = this;
            if(self.active_selecter_user == false){
              self.active_selecter_user = true;
              setTimeout(function () {
                $('.js-search-basic-single').select2({
                  placeholder: 'Select an option'
                });
                $('.js-search-basic-single').focus();

              }, 500);
            } else {
              var dialog = bootbox.dialog({
                title: 'Asignar usuario',
                centerVertical: true,
                message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>'
              });
              let user_select = parseInt($('.js-search-basic-single').val());
              $('.js-search-basic-single').select2('destroy');
              self.active_selecter_user = false;

              if(user_select>0){
                let params = {
                  cmrfid: 'functions',
                  action: 'add-wallet',
                  user: user_select,
                  wallet_uid: self.wallet.uid,
                  wallet_pin: self.wallet.pin,
                };
                dialog.init(function(){
                  PACMEC.api.get("", {
                    params: params
                  })
                  .then((r) => {
                    let result = r.data;
                    console.log('result', result)
                    if(typeof result === 'object' && result !== null && result.message !== null){
                      dialog.find('.bootbox-body').html(result.message);
                    } else {
                      dialog.find('.bootbox-body').html("Ocurrio un error interno, comuniquese con soporte.");
                    }
                  })
                  .catch((e) => {
                    console.log(e);
                    dialog.find('.bootbox-body').html('Ups error.!');
                  })
                  .finally(() => {
                    self.search.query  = self.wallet.uid;
                    self.searchInfo();
                    setTimeout(function(){
                      dialog.modal('hide');
                    }, 1750);
                  });
                });
              } else {
                dialog.find('.bootbox-body').html("user_no_selected");
              }
            }
            return;
      		},
      		addBalance(){
      			let self = this;
      			var dialog = bootbox.dialog({
      				title: 'Agregar saldo.',
      				centerVertical: true,
      				message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>',
      				onHide: function(e) {
      					self.search.query = '';
      					$("#wallet-q").focus();
      				}
      			});
      			if(self.wallet !== null && self.wallet.id !==null && self.wallet.id > 0){
      				bootbox.prompt({
      					centerVertical: true,
      					title: "Ingrese el monto",
      					inputType: 'number',
      					min: 1,
      					callback: function (result) {
      						if(result !== null && result>0){
      							PACMEC.api.get("/", {
      								params: {
      									cmrfid: 'functions',
      									action: 'wallet-actions',
      									action_wallet: 'add',
      									amount: result,
      									uid: self.wallet.uid,
      									pin: self.wallet.pin,
      								}
      							})
      							.then((r) => {
      								if(r.data.message !== undefined){
      									dialog.find('.bootbox-body').html(r.data.message);
      									self.search.query = self.wallet.uid;
      									self.searchInfo();
      								} else {
      									dialog.find('.bootbox-body').html("Ocurrio un error intenta nuevamente.");
      								}
      							})
      							.catch((e) => {
      								dialog.find('.bootbox-body').html("ERROR: " + JSON.stringify(e));
      							})
      							.finally(()=>{
      								setTimeout(function(){
      									dialog.modal('hide');
      								}, 1750);
      							});
      						} else {
      							dialog.modal('hide');
      						}
      					}
      				});
      			} else {
      				dialog.find('.bootbox-body').html('<p>El monedero no es valido.</p>');
      				setTimeout(function(){
      					dialog.modal('hide');
      				}, 1750);
      			}
      		},
      		subtractBalance(){
      			let self = this;
      			var dialog = bootbox.dialog({
      				title: 'Restar saldo.',
      				centerVertical: true,
      				message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>',
      				onHide: function(e) {
      					self.search_q = '';
      					$("#wallet-q").focus();
      				}
      			});

      			if(self.wallet !== null && self.wallet.id !==null && self.wallet.id > 0){
      				bootbox.prompt({
      					centerVertical: true,
      					title: "Ingrese el monto",
      					inputType: 'number',
      					min: 1,
      					callback: function (result) {
      						if(result !== null && result>0){
      							PACMEC.api.get("/", {
      								params: {
      									cmrfid: 'functions',
      									action: 'wallet-actions',
      									action_wallet: 'subtract',
      									amount: result,
      									uid: self.wallet.uid,
      									pin: self.wallet.pin,
      								}
      							})
      							.then((r) => {
      								if(r.data.message !== undefined){
      									dialog.find('.bootbox-body').html(r.data.message);
      									self.search.query = self.wallet.uid;
      									self.searchInfo();
      								} else {
      									dialog.find('.bootbox-body').html("Ocurrio un error intenta nuevamente.");
      								}
      							})
      							.catch((e) => {
      								dialog.find('.bootbox-body').html("ERROR: " + JSON.stringify(e));
      							})
      							.finally(()=>{
      								setTimeout(function(){
      									dialog.modal('hide');
      								}, 1750);
      							});
      						} else {
      							dialog.modal('hide');
      						}
      					}
      				});
      			} else {
      				dialog.find('.bootbox-body').html('<p>El monedero no es valido.</p>');
      				setTimeout(function(){
      					dialog.modal('hide');
      				}, 1750);
      			}
      		},
      		clearBalance(){
      			let self = this;
      			var dialog = bootbox.dialog({
      				title: 'Limpiando saldo.',
      				centerVertical: true,
      				message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>',
      				onHide: function(e) {
      					self.search.query = '';
      					$("#wallet-q").focus();
      				}
      			});

      			if(self.wallet !== null && self.wallet.id !==null && self.wallet.id > 0){
      				PACMEC.api.get("/", {
      					params: {
      						cmrfid: 'functions',
      						action: 'wallet-actions',
      						action_wallet: 'clearing',
      						amount: 0,
      						uid: self.wallet.uid,
      						pin: self.wallet.pin,
      					}
      				})
      				.then((r) => {
      					if(r.data.message !== undefined){
      						dialog.find('.bootbox-body').html(r.data.message);
      						self.search.query = self.wallet.uid;
      						self.searchInfo();
      					} else {
      						dialog.find('.bootbox-body').html("Ocurrio un error intenta nuevamente.");
      					}
      				})
      				.catch((e) => {
      					dialog.find('.bootbox-body').html("ERROR: " + JSON.stringify(e));
      				})
      				.finally(()=>{
      					setTimeout(function(){
      						dialog.modal('hide');
      					}, 1750);
      				});
      			} else {
      				dialog.find('.bootbox-body').html('<p>El monedero no es valido.</p>');
      				setTimeout(function(){
      					dialog.modal('hide');
      				}, 1750);
      			}
      		},
      		addMembership(){
      			let self = this;
      			memberships = self.options.memberships.map(a => {
      				return {
      					text: self._autoT('membership_'+a.id),
      					value: a.id,
      				};
      			});
      			bootbox.prompt({
      				title: self._autoT('select_option'),
      				inputType: 'select',
      				inputOptions: memberships,
      				centerVertical: true,
      				callback: function (membershipId) {
      					if(membershipId!==null){
      						var dialog = bootbox.dialog({
      							title: 'Agregando Membresía',
      							centerVertical: true,
      							message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>'
      						});
      						let params = {
      							cmrfid: 'functions',
      							action: 'add-membership',
      							user: self.user.id,
      							membership: membershipId,
      						};
      						dialog.init(function(){
      							PACMEC.api.get("", {
      								params: params
      							})
      							.then((r) => {
      								let result = r.data;
      								if(typeof result === 'object' && result !== null && result.message !== null){
      									dialog.find('.bootbox-body').html(result.message);
      								} else {
      									dialog.find('.bootbox-body').html("Ocurrio un error interno, comuniquese con soporte.");
      								}
      							})
      							.catch((e) => {
      								console.log(e);
      								dialog.find('.bootbox-body').html('Ups error.!');
      							})
      							.finally(() => {
      								self.search.query = self.wallet.uid;
      								self.searchInfo();
      								setTimeout(function(){
      									dialog.modal('hide');
      								}, 1750);
      							});
      						});
      					}
      				}
      			});
      		},
      		endMembership(){
      			let self = this;
      			var dialog = bootbox.dialog({
      				title: 'Cerrando Membresía',
      				centerVertical: true,
      				message: '<p><i class="fa fa-spin fa-spinner"></i> Espere ...</p>'
      			});
      			let params = {
      				cmrfid: 'functions',
      				action: 'expired-membership',
      				user: self.user.id,
      			};
      			dialog.init(function(){
      				PACMEC.api.get("", {
      					params: params
      				})
      				.then((r) => {
      					let result = r.data;
      					if(typeof result === 'object' && result !== null && result.message !== null){
      						dialog.find('.bootbox-body').html(result.message);
      					} else {
      						dialog.find('.bootbox-body').html("Ocurrio un error interno, comuniquese con soporte.");
      					}
      				})
      				.catch((e) => {
      					console.log(e);
      					dialog.find('.bootbox-body').html('Ups error.!');
      				})
      				.finally(() => {
      					self.search.query  = self.wallet.uid;
      					self.searchInfo();
      					setTimeout(function(){
      						dialog.modal('hide');
      					}, 1750);
      				});
      			});
      		},
      	},
      });

      var List = Vue.extend({
        mixins: [util, orm, pacmec_globals],
        template: '#list',
        data: function () {
          return {
            records: null,
            subject: this.$route.params.subject,
            field: this.$route.params.field,
            id: this.$route.params.id
          };
        },
        props: ['definition'],
        created: function () {
          this.readRecords();
        },
        computed: {
          related: function () {
            return (this.referenced.filter(function (value) { return value; }).length > 0);
          },
          join: function () {
            return Object.values(this.references).filter(function (value) { return value; });
          },
          properties: function () {
            return this.getProperties('list', this.subject, this.definition);
          },
          references: function () {
            return this.getReferences(this.properties);
          },
          referenced: function () {
            return this.getReferenced(this.properties);
          },
          primaryKey: function () {
            return this.getPrimaryKey(this.properties);
          }
        },
        methods: {
          referenceText(subject, record) {
            var properties = this.getProperties('read', subject, this.definition);
            var displayColumn = this.getDisplayColumn(Object.keys(properties));
            return record[displayColumn];
          },
          referenceId(subject, record) {
            var properties = this.getProperties('read', subject, this.definition);
            var primaryKey = this.getPrimaryKey(properties);
            return record[primaryKey];
          }
        }
      });

      var View = Vue.extend({
        mixins: [util, orm],
        template: '#view',
        props: ['definition'],
        data: function () {
          return {
            id: this.$route.params.id,
            subject: this.$route.params.subject,
            record: null
          };
        },
        created: function () {
          this.readRecord();
        },
        computed: {
          properties: function () {
            return this.getProperties('read', this.subject, this.definition);
          }
        },
        methods: {
        }
      });

      var Edit = Vue.extend({
        mixins: [util, orm],
        template: '#update',
        props: ['definition'],
        data: function () {
          return {
            id: this.$route.params.id,
            subject: this.$route.params.subject,
            record: null,
            options: {}
          };
        },
        created: function () {
          this.readRecord();
          this.readOptions();
        },
        computed: {
          properties: function () {
            return this.getProperties('update', this.subject, this.definition);
          },
          primaryKey: function () {
            return this.getPrimaryKey(this.properties);
          },
          references: function () {
            return this.getReferences(this.properties);
          },
        },
        methods: {
        }
      });

      var Delete = Vue.extend({
        mixins: [util, orm],
        template: '#delete',
        data: function () {
          return {
            id: this.$route.params.id,
            subject: this.$route.params.subject
          };
        },
        methods: {
        }
      });

      var Add = Vue.extend({
        mixins: [util, orm],
        template: '#create',
        props: ['definition'],
        data: function () {
          return {
            id: this.$route.params.id,
            subject: this.$route.params.subject,
            record: null,
            options: {}
          };
        },
        created: function () {
          this.initRecord();
          this.readOptions();
        },
        computed: {
          properties: function () {
            return this.getProperties('create', this.subject, this.definition);
          },
          primaryKey: function () {
            return this.getPrimaryKey(this.properties);
          },
          references: function () {
            return this.getReferences(this.properties);
          }
        },
        methods: {
        }
      });

      Vue.component('pacmec-menu-api', {
        mixins: [util, orm, pacmec_globals],
        template: '#pacmec-menu-api-component',
        props: ['subjects']
      });

      const router = new VueRouter({
        // linkActiveClass: 'active',
        routes:[
          { path: '/', component: Home, name: 'Home' },
          { path: '/:subject/create', component: Add, name: 'Add'},
          { path: '/:subject/read/:id', component: View, name: 'View'},
          { path: '/:subject/update/:id', component: Edit, name: 'Edit'},
          { path: '/:subject/delete/:id', component: Delete, name: 'Delete'},
          { path: '/:subject/list', component: List, name: 'List'},
          { path: '/:subject/list/:field/:id', component: List, name: 'Filter'}
        ]
      });

      const APP = new Vue({
        router: router,
        data: {
          definition: null,
    			glossary: null,
    			lang: '<?= $GLOBALS['PACMEC']['lang']; ?>',
    			list_menus: null,
          userStatus: null,
      		options: {
      			users: [],
      		},
      		bracelets_types: {
      			'card' : "Tarjeta",
      			'keychain' : "Llavero",
      			'bracelet' : "Brazalete",
      			'adhesive' : "Adhesivo",
      			'codebar' : "Código de barras",
      			'tag' : "Etiqueta",
      			'other' : "Otro"
      		},
      		bracelets_status: {
      			'active' : "Activo",
      			'lost' : "Perdido",
      			'locked' : "Bloqueado",
      			'not_activated' : "No activado",
      			'recovered' : "Recuperado"
      		},
      		translate_days: { 'Monday':'Lunes', 'Tuesday':'Martes', 'Wednesday':'Miercoles', 'Thursday':'Jueves', 'Friday':'Viernes', 'Saturday':'Sabado', 'Sunday':'Domingo' },
      		translate_days_min: {'Monday':'mon','Tuesday':'tue','Wednesday':'wed','Thursday':'thu','Friday':'fri','Saturday':'sat','Sunday':'sun'},
      		translate_slugs_icons: {'access':'fas fa-key','comfort':'fas fa-sunglasses','benefit':'fas fa-heart','other':'fas fa-star','discount':'fas fa-badge-dollar'},
      		translate_cycles_periods_plu: {'Day':'Días','Week':'Semanas','Month':'Meses','Year':'Años'},
      		translate_cycles_periods_sin: {'Day':'Día','Week':'Semana','Month':'Mes','Year':'Año'},
      	},
        created(){
          let self = this;
          self.initOA();
        },
        computed: {
          lang_labels(){
      			var self = this;
      			let r = [];
      			if(self.glossary!==null){
      				r = self.glossary.find(a => a.tag == self.lang).glossary_txt.map(b => {
      					return { slug: b.slug, label: b.text };
      				});
      			}
      			return r;
      		},
          lang_id(){
            var self = this;
      			let r = 0;
      			if(self.glossary!==null){
      				let it = self.glossary.find(a => a.tag == self.lang);
              if(it.id){
                r = it.id;
              }
      			}
      			return r;
          }
        },
        mounted(){
      		let self = this;
      		self.$nextTick(function () {
      		});
      	},
        methods: {
          statusChangeCallback(response) {
      			let self = this;
      			self.userStatus = response;
      			if (response.status === 'connected') {
      				console.log('Usuario con sesion');
      			} else if (response.status === 'not_authorized') {
      				console.log('Sitio web no autorizado.');
      			} else if (response.status === 'not_connected') {
      				console.log('Inicie sesión en esta página web.');
      			} else {
      				console.log('La app no está activa o contiene errores...');
      			}
      		},
      		checkLoginState() {
      			var self = this;
      			// console.log('checkLoginState');
      			PACMEC.getLoginStatus(function(response) {
      				// console.log('checkLoginState.getLoginStatus',response);
      				self.statusChangeCallback(response);
      			});
      		},
      		initOA(){
      			let self = this;
      			self.checkLoginState();
      			PACMEC.list('openapi', {}, function(a){
      				if(a.status == 200){
      					self.definition = a.response;
      					document.title = self.definition.info.title;
      				}
      				PACMEC.list('glossary', {
      					join: [
      						'glossary_txt',
      					],
      				}, function(b){
      					if(b.status == 200){
      						self.glossary = b.response;
      						//self.lang = b.response.find(z => z.is_default == 1).tag;
      					}
      					PACMEC.list('menus', {
      						join: [
      							'menus_elements',
      						],
      					}, function(c){
      						if(c.status == 200){
      							self.list_menus = [];
      							c.response.forEach(z => {
      								 self.list_menus[z.slug] = z.menus_elements;
      							});
      						}
      					});
      				});
      			}, '/');
      		},
          loadAPI(){
            let self = this;
            PACMEC.api.get('/openapi').then(function (response) {
              console.log('response OpenApi: ', response)
              self.definition = response.data;
            }).catch(function (error) {
              console.log(error);
            });
            PACMEC.api.get('/openapi').then(function (response) {
              console.log('response OpenApi: ', response)
              self.definition = response.data;
            }).catch(function (error) {
              console.log(error);
            });
          },
          logout(){
      			var self = this;
      			let re = null;
      			PACMEC.api.post('/logout', {
      			})
      			.then((r) => { re = r; })
      			.catch((e) => { re = e.response; })
      			.finally(() => {
      				// console.log(re);
      				location.replace('/');
      			});
      		},
          translateField(field_slug){
      			let self = this;
      			try {
      				if(self.lang !== null && self.glossary !== null){
      					let label = self.lang_labels.find((z,x) => z.slug == field_slug);
      					if(label !== undefined && label.label !== undefined){ return label.label; }
      				}
      				return "Þ{" + field_slug + "}";
              let parametros = {
                filter: [
                  'glossary_id,eq,'+self.lang_id,
                  'slug,eq,'+field_slug,
                ]
              };
              PACMEC.list('glossary_txt', parametros, (z)=>{
                if(z.error == false && z.response.length==0){
                  PACMEC.create('glossary_txt', {
                    glossary_id: self.lang_id,
                    slug: field_slug,
                    text: `þ{`+field_slug+`}`
                  }, (x)=>{

                  });
                }
              });
              return "þ{" + field_slug + "}";
      			} catch(e) {
      				console.log('error tras', e);
      				return "Þ{" + field_slug + "}";
      			}
      		},

      		// zfill: PACMEC.format.zfill,
      		// formatMoney: PACMEC.format.formatMoney,
      		// makeid: PACMEC.format.makeid,
      	},
      }).$mount('#main-app');
    </script>
  </body>
</html>
