<!-- name -->
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">
@lang('messages.name')
</label>
        <a data-toggle="collapse" href="#hint1" class="btn btn-default">?</a>
	    <div class="col-sm-6">
	<input type="text" name="name" id="name" class="form-control" value="{{ old('name', isset($taxon) ? $taxon->fullname : null) }}">
            </div>
  <div class="col-sm-12">
    <div id="hint1" class="panel-collapse collapse">
	@lang ('messages.hint_taxon_name')
    </div>
  </div>
</div>

		        <div class="form-group">
			    <div class="col-sm-offset-3 col-sm-6">
				<button type="submit" class="btn btn-primary" id="checkapis">
				    <i class="fa fa-btn fa-plus"></i>
@lang('messages.checkapis')
				</button>
				<div class="spinner" id="spinner"> </div>
			    </div>
			</div>

<!-- tax rank -->
<div class="form-group">
    <label for="level" class="col-sm-3 control-label">
@lang('messages.taxon_level')
</label>
        <a data-toggle="collapse" href="#hint2" class="btn btn-default">?</a>
	    <div class="col-sm-6">
	<?php $selected = old('level', isset($taxon) ? $taxon->level : null); ?>

	<select name="level" id="level" class="form-control" >
	@foreach (App\Taxon::TaxLevels() as $level)
		<option value="{{$level}}" {{ $level == $selected ? 'selected' : '' }}>
			@lang ('levels.tax.' . $level )
		</option>
	@endforeach
	</select>
            </div>
  <div class="col-sm-12">
    <div id="hint2" class="panel-collapse collapse">
	@lang('messages.taxon_level_hint')
    </div>
  </div>
</div>

<!-- parent -->
<div class="form-group">
    <label for="parent_id" class="col-sm-3 control-label">
@lang('messages.parent')
</label>
        <a data-toggle="collapse" href="#hint6" class="btn btn-default">?</a>
	    <div class="col-sm-6">
	<?php $selected = old('parent_id', isset($taxon) ? $taxon->parent_id : null); ?>

	<select name="parent_id" id="parent_id" class="form-control" >
        <option value = '' ></option>
	@foreach ($taxons as $parent)
		<option value="{{$parent->id}}" {{ $parent->id == $selected ? 'selected' : '' }}>
            {{ $parent->fullname }}
		</option>
	@endforeach
	</select>
            </div>
  <div class="col-sm-12">
    <div id="hint6" class="panel-collapse collapse">
	@lang('messages.taxon_parent_hint')
    </div>
  </div>
</div>

<!-- senior & is valid -->
<div class="form-group">
    <label for="senior_id" class="col-sm-3 control-label">
@lang('messages.senior')
</label>
        <a data-toggle="collapse" href="#hint4" class="btn btn-default">?</a>
	    <div class="col-sm-6">
	<?php $selected = old('senior_id', isset($taxon) ? $taxon->senior_id : null); ?>

	<select name="senior_id" id="senior_id" class="form-control" >
        <option value = '' ></option>
	@foreach ($taxons as $senior)
		<option value="{{$senior->id}}" {{ $senior->id == $selected ? 'selected' : '' }}>
            {{ $senior->fullname }}
		</option>
	@endforeach
	</select>
            </div>
  <div class="col-sm-12">
    <div id="hint4" class="panel-collapse collapse">
	@lang('messages.taxon_senior_hint')
    </div>
  </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-3">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="valid" id="valid" {{ old('valid', isset($taxon) ? $taxon->valid : null ) ? 'checked' : '' }}>
@lang('messages.valid')?

            </label>
        </div>
    </div>
</div>

<!-- tax author -->
<div class="form-group">
    <label for="author_id" class="col-sm-3 control-label">
@lang('messages.taxon_author')
</label>
        <a data-toggle="collapse" href="#hint3" class="btn btn-default">?</a>
	    <div class="col-sm-6 group-together">
	<input type="text" name="author" id="author" class="form-control" value="{{ old('author', isset($taxon) ? $taxon->author : null) }}">
<div style="text-align:center;">- or -</div>
	<?php $selected = old('author_id', isset($taxon) ? $taxon->author_id : null); ?>

	<select name="author_id" id="author_id" class="form-control" >
        <option value=''></option>
	@foreach ( $persons as $person )
		<option value="{{$person->id}}" {{ $person->id == $selected ? 'selected' : '' }}>
            {{ $person->full_name }}
		</option>
	@endforeach
	</select>
            </div>
  <div class="col-sm-12">
    <div id="hint3" class="panel-collapse collapse">
	@lang('messages.taxon_author_hint')
    </div>
  </div>
</div>

<!-- tax reference -->
<div class="form-group">
    <label for="bibreference_id" class="col-sm-3 control-label">
@lang('messages.taxon_bibreference')
</label>
        <a data-toggle="collapse" href="#hint5" class="btn btn-default">?</a>
	    <div class="col-sm-6 group-together">
	<input type="text" name="bibreference" id="bibreference" class="form-control" value="{{ old('bibreference', isset($taxon) ? $taxon->bibreference : null) }}">
<div style="text-align:center;">- or -</div>
	<?php $selected = old('bibreference_id', isset($taxon) ? $taxon->bibreference_id : null); ?>

	<select name="bibreference_id" id="bibreference_id" class="form-control" >
        <option value=''></option>
	@foreach ( $references as $reference )
		<option value="{{$reference->id}}" {{ $reference->id == $selected ? 'selected' : '' }}>
            {{ $reference->bibkey }}
		</option>
	@endforeach
	</select>
            </div>
  <div class="col-sm-12">
    <div id="hint5" class="panel-collapse collapse">
	@lang('messages.taxon_bibreference_hint')
    </div>
  </div>
</div>

<!-- External refs -->
<div class="form-group">
    <label for="mobotkey" class="col-sm-3 control-label">
@lang('messages.mobot_key')
</label>
        <a data-toggle="collapse" href="#hint7" class="btn btn-default">?</a>
	    <div class="col-sm-6">
	<input type="text" name="mobotkey" id="mobotkey" class="form-control" value="{{ old('mobotkey', isset($taxon) ? $taxon->mobot : null) }}">
            </div>
</div>
<div class="form-group">
    <label for="ipnikey" class="col-sm-3 control-label">
@lang('messages.ipni_key')
</label>
	    <div class="col-sm-6">
	<input type="text" name="ipnikey" id="ipnikey" class="form-control" value="{{ old('ipnikey', isset($taxon) ? $taxon->ipni : null) }}">
            </div>
</div>
<div class="form-group">
    <label for="mycobankkey" class="col-sm-3 control-label">
@lang('messages.mycobank_key')
</label>
	    <div class="col-sm-6">
	<input type="text" name="mycobankkey" id="mycobankkey" class="form-control" value="{{ old('mycobankkey', isset($taxon) ? $taxon->mycobank : null) }}">
            </div>
  <div class="col-sm-12">
    <div id="hint7" class="panel-collapse collapse">
	@lang ('messages.hint_mobot_key')
    </div>
  </div>
</div>

<!-- notes --> 
<div class="form-group">
    <label for="notes" class="col-sm-3 control-label">
@lang('messages.notes')
</label>
	    <div class="col-sm-6">
	<textarea name="notes" id="notes" class="form-control">{{ old('notes', isset($taxon) ? $taxon->notes : null) }}</textarea>
            </div>
</div>
