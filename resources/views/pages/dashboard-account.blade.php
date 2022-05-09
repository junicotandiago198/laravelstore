@extends('layouts.dashboard')

@section('title')
  Account Setting
@endsection

@section('content')
<!-- Section Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">My Account</h2>
      <p class="dashboard-subtitle">Update your current profile</p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12">
          <form action="{{ route('dashboard-settings-redirect','dashboard-settings-account') }}" method="POST" enctype="multipart/form-data" id="locations">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="addressOne">Your Name</label>
                      <input type="text" class="form-control" id="addressOne" name="name" value="{{ $user->name }}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="addressOne">Your Email</label>
                      <input type="email" class="form-control" id="addressOne" name="email" value="{{ $user->email }}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="addressOne">Address 1</label>
                      <input type="text" class="form-control" id="addressOne" name="address_one" value="{{ $user->address_one }}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="addressTwo">Address 1</label>
                      <input type="text" class="form-control" id="addressTwo" name="address_two" value="{{ $user->address_one }}" />
                    </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                      <label for="provinces_id">Province</label>
                      <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                          <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                      </select>
                      <select v-else class="form-control"></select>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                      <label for="regencies_id">City</label>
                      <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                          <option v-for="regenci in regencies" :value="regenci.id">@{{ regenci.name }}</option>
                      </select>
                      <select v-else class="form-control"></select>
                      </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="postalCode">Postal Code</label>
                      <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $user->zip_code }}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" class="form-control" id="country" name="country" value="{{ $user->country }}" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col text-right">
                    <button type="submit" class="btn btn-success px-5">Save Now</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var locations = new Vue({
        el: "#locations",
        mounted() {
            AOS.init();
            this.getProvincesData();
        },
        data: {
            provinces: null,
            regencies: null,
            provinces_id: null,
            regencies_id: null
        },
        methods: {
            getProvincesData() {
            var self = this;
                axios.get('{{ route('api-provinces') }}')
                .then(function(response) {
                    self.provinces = response.data;
                })
            },
            getRegenciesData(){
            var self = this;
                axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                .then(function(response) {
                    self.regencies = response.data;
                })
            },  
        },
        watch: {
            provinces_id: function(val, oldVal){
                this.regencies_id = null;
                this.getRegenciesData();
            }
        }
        });
    </script>
@endpush