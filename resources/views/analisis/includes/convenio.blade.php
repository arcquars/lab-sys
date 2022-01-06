<div class="row banca_seccion">
    <div class="col-md-4 form-group">
        <label for="bancaInstitucion" style="color: #000;">Institucion</label>
        <input type="text" name="bancaInstitucion" class="form-control @error('bancaInstitucion') is-invalid @enderror"
               value="{{ old('bancaInstitucion')? old('bancaInstitucion') : ( (isset($convenio))? $convenio->bancaInstitucion : '' ) }}">
        @error('bancaInstitucion')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="bancaMatricula" style="color: #000;">Matricula del paciente</label>
        <input type="text" name="bancaMatricula" class="form-control @error('bancaMatricula') is-invalid @enderror"
               value="{{ old('bancaMatricula')? old('bancaMatricula') : ( (isset($convenio))? $convenio->bancaMatricula : '' ) }}">
        @error('bancaMatricula')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="bancaPreAfiliacion" style="color: #000;">Pre afiliacion</label>
        <input type="text" name="bancaPreAfiliacion" class="form-control @error('bancaPreAfiliacion') is-invalid @enderror"
               value="{{old('bancaPreAfiliacion')? old('bancaPreAfiliacion') : ( (isset($convenio))? $convenio->bancaPreAfiliacion : '' ) }}">
        @error('bancaPreAfiliacion')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row banca_seccion">
    <div class="col-md-4">
        <h6 class="titleBancaIngreso">Activo</h6>
        <div class="form-group">
            <input type="checkbox" name="bancaActivoAsegurado"
                   value="1" {{old('bancaActivoAsegurado')? 'checked' : ( (isset($convenio) && $convenio->bancaActivoAsegurado == 1)? 'checked' : '' ) }}> Asegurado
            @error('bancaActivoAsegurado')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaActivoExt"
                   value="1" {{old('bancaActivoExt')? 'checked' : ( (isset($convenio) && $convenio->bancaActivoExt == 1)? 'checked' : '' ) }}> Ext. 19-25
            @error('bancaActivoExt')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaActivoResto"
                   value="1" {{old('bancaActivoResto')? 'checked' : ( (isset($convenio) && $convenio->bancaActivoResto == 1)? 'checked' : '' ) }}> Rest Benef.
            @error('bancaActivoResto')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="titleBancaIngreso">Pasivo</h6>
        <div class="form-group">
            <input type="checkbox" name="bancaPasivoAsegurado"
                   value="1" {{old('bancaPasivoAsegurado')? 'checked' : ( (isset($convenio) && $convenio->bancaPasivoAsegurado == 1)? 'checked' : '' ) }}> Asegurado
            @error('bancaPasivoAsegurado')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaPasivoExt"
                   value="1" {{old('bancaPasivoExt')? 'checked' : ( (isset($convenio) && $convenio->bancaPasivoExt == 1)? 'checked' : '' ) }}> Ext. 19-25
            @error('bancaPasivoExt')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaPasivoResto"
                   value="1" {{old('bancaPasivoResto')? 'checked' : ( (isset($convenio) && $convenio->bancaPasivoResto == 1)? 'checked' : '' ) }}> Rest Benef.
            @error('bancaPasivoResto')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <h6 class="titleBancaIngreso">Sec. Vol.</h6>
        <div class="form-group">
            <input type="checkbox" name="bancaSecAsegurado"
                   value="1" {{old('bancaSecAsegurado')? 'checked' : ( (isset($convenio) && $convenio->bancaSecAsegurado == 1)? 'checked' : '' ) }}> Asegurado
            @error('bancaSecAsegurado')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaSecExt"
                   value="1" {{old('bancaSecExt')? 'checked' : ( (isset($convenio) && $convenio->bancaSecExt == 1)? 'checked' : '' ) }}> Ext. 19-25
            @error('bancaSecExt')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="checkbox" name="bancaSecResto"
                   value="1" {{old('bancaSecResto')? 'checked' : ( (isset($convenio) && $convenio->bancaSecResto == 1)? 'checked' : '' ) }}> Rest Benef.
            @error('bancaSecResto')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row banca_seccion">
    <div class="col-md-4 form-group">
        <label for="bancaEspecialidad" style="color: #000;">Especialidad</label>
        <input type="text" name="bancaEspecialidad" class="form-control @error('bancaEspecialidad') is-invalid @enderror"
               value="{{old('bancaEspecialidad')? old('bancaEspecialidad') : ( (isset($convenio))? $convenio->bancaEspecialidad : '' ) }}">
        @error('bancaEspecialidad')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="bancaAmbulatorio" style="color: #000;">Ambulatorio</label>
        <input type="text" name="bancaAmbulatorio" class="form-control @error('bancaAmbulatorio') is-invalid @enderror"
               value="{{old('bancaAmbulatorio')? old('bancaAmbulatorio') : ( (isset($convenio))? $convenio->bancaAmbulatorio : '' ) }}">
        @error('bancaAmbulatorio')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="bancaHospitalizado" style="color: #000;">Hospitalizado</label>
        <input type="text" name="bancaHospitalizado" class="form-control @error('bancaHospitalizado') is-invalid @enderror"
               value="{{old('bancaHospitalizado')? old('bancaHospitalizado') : ( (isset($convenio))? $convenio->bancaHospitalizado : '' ) }}">
        @error('bancaHospitalizado')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
