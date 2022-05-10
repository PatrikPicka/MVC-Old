<?php 
$menu = Router::getMenu('menu_acl');
$currentPage  = currentPage();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?=PROOT?>home"><?= MENU_BRAND ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="main_menu">
    <ul class="navbar-nav mr-auto">
      <?php   foreach($menu as $menu_item => $value): 
          $active = ''; ?>
          <?php if(is_array($value)): ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?=$menu_item ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php foreach ($value as $mi => $v):
                      $active = ($v == $currentPage)? 'active' : '';
                  ?>
                  <?php if($mi != 'separator'): ?>
                    
                    <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$mi?></a>
                  <?php else: ?>
                    <div class="dropdown-divider"></div>

                  <?php endif; ?>
                <?php   endforeach; ?>
              </div>
            </li>
          <?php else: 
                $active = ($value == $currentPage)? 'active' : '';
          ?>
              <a class="dropdown-item <?=$active?>" href="<?=$value?>"><?=$menu_item?></a>

          <?php endif; ?>
      <?php   endforeach; ?>
    </ul>
      <?php   if(isLoggedIn()): ?>
        <ul class="navbar-nav navbar-right">
          <li class="nav-item my-2 my-lg-0">
            <a class="nav-link" href="#">Hello <?= currentUser()->fname ?> <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      <?php endif; ?>
  
  </div>
</nav>
