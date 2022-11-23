<nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        
        
      </li>
      <!--li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li-->
    </ul>




  </nav>
  <?php 
    if(! session()->get('mode') ){
       session()->put('mode', 'test'); 
    }
     $mode = session()->get('mode');   
  ?>  
  <div class="<?= $mode ?>-mode-dashboard">You're In 
  <select id="change_mode" class="btn btn-sm btn-<?= ($mode == 'test' ? 'danger' : 'success') ?>">    
    <option value="test" <?= ($mode == 'test' ? 'selected' : '') ?>>Test</option>
    <option value="live" <?= ($mode == 'live' ? 'selected' : '') ?>>Live</option>
  </select>
    Mode
   </div>
<style type="text/css">
  .live-mode-dashboard {
    position: fixed;
    top: 0px;
    left: 50%;
    color: white;
    font-weight: bold;
    background: green;
    padding: 0px 21px;
    border-radius: 0px 0px 5px 5px;
    transform: translateX(-50%);
    z-index: 9999;
}
  .test-mode-dashboard {
    position: fixed;
    top: 0px;
    left: 50%;
    color: white;
    font-weight: bold;
    background: red;
    padding: 0px 21px;
    border-radius: 0px 0px 5px 5px;
    transform: translateX(-50%);
    z-index: 9999;
}
</style>
 