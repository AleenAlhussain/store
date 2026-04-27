<div class="row">
    @foreach($apps as $row)
        <div class="col-lg-2 col-md-3 col-sm-12" id="{{$row->appid}}">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="{{ asset('public/images/') }}/{{$row->cover}}" alt="Product" class="img-fluid">
                    </div>
                    <div class="product_details">
                        <h5 class="trunc">{{$row->stitle??$row->title}}</h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price"><a href="{{action('ApplicationController@edit', $row->appid)}}"
                                                     class="btn btn-primary btn-sm waves-effect"><i
                                        class="notika-icon notika-edit"></i></a></li>
                            <li class="new_price">
                                <a href="javascript:void(0);" data-url="{{ route('apps.destroy',$row->appid) }}"
                                   data-id="{{$row->appid}}" class="btn btn-primary btn-sm waves-effect _delete_data"><i
                                        class="notika-icon notika-trash"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="pagination-inbox text-center">
    {!! $apps->links() !!}
</div>
