                    <footer class="py-4 bg-light mt-auto">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between small">
                                <div class="text-muted">Copyright &copy; Sonder 2023 Version 1.00</div>
                                    <div>
                                        <a href="#">Privacy Policy</a>
                                        &middot;
                                        <a href="#">Terms &amp; Conditions</a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="MAcercade">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" >
                                        <div class="container-fluid" >
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="col-md-12 col-lg-5 d-none d-md-block" >
                                                        <img src="Imagen/cabecera.png"  height="55"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="col-md-6" >
                                                        <img src="Imagen/Logo3.png" width="200" />
                                                    </div>
                                                </div>  
                                                <div class="col-md-1">
                                                    <div class="col-md-6 " >
                                                        
                                                    </div>
                                                </div>                                           
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <FONT  SIZE=3 COLOR="red">
                                                            <div class="col-md-12"><b>SISTEMA WEP</b></div>                                                
                                                            </FONT>
                                                        </div>
                                                        <br>
                                                        <FONT SIZE=2>
                                                            <div class="row">
                                                                <div class="col-md-12">Sistema de Control XXXX Diseñado bajo las normativas de Software Libre Coordinada por el Área de Informática de <b><i>Misión Sucre, Aldea Severiano Rodríguez Hernández <i></b></div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12"><b>Diseñador:</b> XXX XXXX</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12"><b>Tutor Académico:</b> Ing. Jhonny Carbonel</div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12"><b>Coordinadora:</b> Lic. Luz Linares </div>                                                
                                                            </div>
                                                        </FONT>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div> 
                                        <div class="modal-footer">
                                            <div class="form-row">
                                                <div class="col-md-9">                                                    
                                                <FONT SIZE=2><div >Copyright &copy; Sonder 2023 </div></FONT>                                                
                                                </div>
                                                <div class="col-md-3">                                                    
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">X</button> 
                                                </div>
                                            </div>
                                            
                                        </div>								
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
         <script src="js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>        
        <script src="js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
		<script src="assets/demo/datatables-demo.js"></script>
	</body>
</html>

<script>
	$(document).ready(function() {
		document.getElementById("TAcerca").onclick  =MostrarAcerca;
	} );

	function MostrarAcerca()
	{
		//alert("Submit button is clicked!");
		//$('#exampleModal').modal('hide');
		$('#MAcercade').modal({ show:true });
	}			
</script>
			

