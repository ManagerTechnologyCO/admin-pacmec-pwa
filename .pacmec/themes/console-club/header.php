<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<!DOCTYPE HTML>
<html <?= language_attributes(); ?>>
   <head>
       <meta charset="<?= pageinfo( 'charset' ); ?>" />
       <title><?= pageinfo( 'title' ); ?></title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
       <meta name="robots" content="index, follow"/>
       <meta name="keywords" content=""/>
       <meta name="description" content=""/>
       <?php pacmec_head(); ?>
       <style>
       * {
         padding: 0;
         margin: 0;
       }

       #panel-main {
         height: calc(100vh);
         width: calc(100vw);
         overflow: hidden;
       }

       #panel-top {
         background-color: #50FdFa55;
         float: left;
         width: calc(100vw);
       }

       #panel-left {
         background-color: #666666;
         float: left;
         height: calc(95vh);
         width: calc(19vw);
         overflow-y: auto;
       }

       #panel-right {
         background-color: #DDDDDD55;
         float: left;
         height: calc(95vh);
         width: calc(80vw);
         overflow-y: auto;
       }

       #panel-right-contents {
         background-color: #ffeb3b35;
         width: 100%;
         height: calc(90vh);
       }
       </style>
   </head>
   <body>
     <div id="main">
       <div id="panel-main">
         <component is="menu-top"></component>
         <div id="panel-left">
           <fieldset id="default" style="margin-bottom:20px">
              <legend>Default</legend>
              The story begins as Don Vito Corleone, the head of a New York Mafia family, oversees his daughter's wedding.
              His beloved son Michael has just come home from the war, but does not intend to become part of his father's business.
              Through Michael's life the nature of the family business becomes clear. The business of the family is just like the head of the family,
              kind and benevolent to those who give respect,
              but given to ruthless violence whenever anything stands against the good of the family.
          </fieldset>
           
          <fieldset id="toggle">
              <legend>Toggleable</legend>
              The story begins as Don Vito Corleone, the head of a New York Mafia family, oversees his daughter's wedding.
              His beloved son Michael has just come home from the war, but does not intend to become part of his father's business.
              Through Michael's life the nature of the family business becomes clear. The business of the family is just like the head of the family,
              kind and benevolent to those who give respect,
              but given to ruthless violence whenever anything stands against the good of the family.
          </fieldset>
           
          <script type="text/javascript">
              $(function() {
                  $('#default').puifieldset();
           
                  $('#toggle').puifieldset({
                      toggleable: true
                  });
              });
          </script>
         </div>
         <div id="panel-right">
           <ul id="panel-right-tabs">
             <li><a href="#tab1">Tab 1</a><span class="fa fa-close"></span></li>
             <li><a href="#tab2">Tab 2</a><span class="fa fa-close"></span></li>
             <li><a href="#tab3">Tab 3</a><span class="fa fa-close"></span></li>
           </ul>
           <div id="panel-right-contents">
             <div id="tab1">
                 The story begins as Don Vito Corleone, the head of a New York Mafia family, oversees his daughter's wedding. His beloved son Michael has just come home from the war, but does not intend to become part of his father's business. T hrough Michael's life the nature of the family business becomes clear. The business of the family is just like the head of the family, kind and benevolent to those who give respect, but given to ruthless violence whenever anything stands against the good of the family.
             </div>
             <div id="tab2">
                 Francis Ford Coppola's legendary continuation and sequel to his landmark 1972 film, The_Godfather, parallels the young Vito Corleone's rise with his son Michael's spiritual fall, deepening The_Godfather's depiction of the dark side of the American dream. In the early 1900s, the child Vito flees his Sicilian village for America after the local Mafia kills his family. Vito struggles to make a living, legally or illegally, for his wife and growing brood in Little Italy, killing the local Black Hand Fanucci after he demands his customary cut of the tyro's business. With Fanucci gone, Vito's communal stature grows.
             </div>
             <div id="tab3">
                 After a break of more than 15 years, director Francis Ford Coppola and writer Mario Puzo returned to the well for this third and final story of the fictional Corleone crime family. Two decades have passed, and crime kingpin Michael Corleone, now divorced from his wife Kay has nearly succeeded in keeping his promise that his family would one day be completely legitimate.
             </div>
           </div>
         </div>
       </div>
     </div>

     <template id="panel-top-component">
       <div>
         <ul id="mb2">
            <li> <a data-icon="fa-file-o">File</a>
                <ul>
                    <li><a data-icon="fa-plus">New</a>
                        <ul>
                            <li><a>Project</a></li>
                            <li><a>Other</a></li>
                        </ul>
                    </li>
                    <li><a>Open</a></li>
                    <li><a>Quit</a></li>
                </ul>
            </li>
            <li> <a data-icon="fa-edit">Edit</a>
                <ul>
                    <li><a data-icon="fa-mail-forward">Undo</a></li>
                    <li><a data-icon="fa-mail-reply">Redo</a></li>
                </ul>
            </li>
            <li>
                <a data-icon="fa-question">Help</a>
                <ul>
                    <li><a>Contents</a></li>
                    <li>
                        <a data-icon="fa-search">Search</a>
                        <ul>
                            <li><a>Text</a>
                                <ul>
                                    <li><a>Workspace</a></li>
                                </ul>
                            </li>
                            <li><a>File</a></li>
                        </ul>
                    </li>

                </ul>

            </li>
            <li>
                <a data-icon="fa-gear">Actions</a>
                <ul>
                    <li><a data-icon="fa-refresh">Edit</a>
                        <ul>
                            <li><a data-icon="fa-save">Save</a></li>
                            <li><a data-icon="fa-save">Update</a></li>
                        </ul>
                    </li>
                    <li><a data-icon="fa-phone">Other</a>
                        <ul>
                            <li><a data-icon="fa-minus">Delete</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/" data-icon="fa-close">Quit</a>
            </li>
        </ul>
       </div>
     </template>

<script>
function addTab(){
  $('#panel-right-tabs').append('<li><a href="#tab4">Tab 1</a><span class="fa fa-close"></span></li>');
  $('#panel-right-contents').append('<div id="tab4"> break of more than 15 years, director Francis Ford Coppola and wri</div>');
  $('#panel-right').puitabview('destroy')
  $('#panel-right').puitabview();
}

window.addEventListener('load', function(){
  $('#panel-right').puitabview();
});

Vue.component('menu-top', {
	template: '#panel-top-component',
	data: function () {
		return {
		};
	},
	created(){
		let self = this;

	},
	mounted(){
		let self = this;
		console.log('mounted Panel');
    $('#mb2').puimenubar({
      autoDisplay: false
    });
		self.$nextTick(function () {
		})
	},
})

const app = new Vue({
  data: function () {
		return {
		};
	},
  mounted(){
		let self = this;
		console.log('mounted App');
		self.$nextTick(function () {
		});
	},
}).$mount('#main');
</script>
