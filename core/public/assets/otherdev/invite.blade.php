@extends('layouts.user')

@section('css')
    <style>
        .input-and-suggestion {
            position: relative;
        }
        .input-and-suggestion input {
            height: 50px;
            border-radius: 10px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }
        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 99999;
            width: 100%;
            padding: 20px;
            font-size: 16px;
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 10px;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }
        .suggestions ul {
            margin: 0;
            padding: 0;
        }
        .suggestions ul li {
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, .10);
            padding-bottom: 15px;
            color: #000000;
        }
        .suggestions ul li {
            list-style: none;
            display: block;
            cursor: pointer;
        }
        .suggestions ul li img {
            height: 50px;
            width: 50px;
            border-radius: 100%;
            margin-right: 5px;
        }
        .suggestions ul li:last-child {
            margin-bottom: 0px;
            border-bottom: none;
            padding-bottom: 0px;
        }
        .selected {
            overflow: hidden;
            margin-bottom: 15px;
        }
        .selected ul {
            margin:  0;
            padding:  0;
        }

        .selected ul li {
            list-style:  none;
            background: #223245;
            padding: 0px 10px 0px;
            display: inline-block;
            margin-right: 10px;
            line-height: 2;
            border-radius: 5px;
            position:  relative;
            margin-bottom: 10px;
        }

        .selected ul li .times {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #07CB79;
            width: 15px;
            height: 15px;
            content: 'x';
            cursor: pointer;
            overflow: hidden;
            line-height: 12px;
            font-size: 12px;
            text-align: center;
            border-radius: 50%;
            font-weight: 700;
        }
        .selected ul li img {
            width: 32px;
            height:  32px;
            border-radius:  50%;
            margin: 5px 0px;
            margin-right: 5px;
        }
    </style>
@endsection

@section('content')

    @if($group->isCreator() || $group->isAdmin() || $group->isModerator() || $group->isMember())

        <div class="clearfix"></div>

        <div class="create-new-post-wrapper">

            <div class="content">
                <div class="selected" v-if="selected.length > 0">
                    <h4 class="section-title"></h4>
                    <form action="{{ route('user.group.invite.send', $group->slug) }}"  method="post">
                        @csrf
                        <ul>
                            <li v-for="(item, index) in selected" :key="index"><img :src="'{{ asset('assets/front/img/') }}/'+item.avatar" :alt="item.name">
                                @{{ item.name }}<span class="times" @click="removeSelected(index)">x</span>
                                <input type="hidden" name="selected[]" :value="item.id">
                            </li>
                        </ul>
                        <button class="btn btn-sm btn-success pull-right"><i class="fa fa-check-circle"></i> Send Invitation</button>
                    </form>
                </div>
                <div class="input-and-suggestion">
                    <form id="inviteForm" @submit.prevent="checkUser">
                        <input type="text" @keyup="getUser" placeholder="Type Username Or Name..." class="post-input-field" v-model="keyword" id="inviteInput" value="">
                    </form>
                    <div class="suggestions" v-if="suggestions.length > 0">
                        <ul>
                            <li v-for="(item, index) in suggestions" :key="index" @click="selectUser(index)"><img :src="'{{ asset('assets/front/img/') }}/'+item.avatar" :alt="item.name"> @{{ item.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    @endif

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                keyword: '',
                suggestions: [],
                selected: []
            },
            methods: {
                checkUser() {
                    this.selected.push(this.suggestions[1]);
					//console.log('check');
					
                },
                selectUser(index) {
                    var user = this.suggestions[index];
                    this.selected.push(user);
                    this.suggestions.splice(index, 1);
					console.log('select');
					
					$('#inviteInput').val("");
					
                },
                removeSelected(index) {
                    var user = this.selected[index];
                    this.suggestions.push(user);
                    this.selected.splice(index, 1);
                },
                getUser() {
                    var selected = this.selected.map(o => o['id']);
                    console.log(selected);
                    axios.post('{{ route('user.group.suggestion', $group->slug) }}', {
                        _token: '{{ csrf_token() }}',
                        key: this.keyword,
                        selected: selected
                    }).then(function (response) {
                        // console.log(response.data);
                        app.suggestions = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            }
        });
    </script>
@endsection