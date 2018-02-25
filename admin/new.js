<script>     
       var itemcnt = 0; var buildcnt = 0;
        
         function additem(sender) { 
        
         out = ''; 
        
        
         out += '<tr>'; 
                 
         out += '<td></td>'; 
         out += '<td>'; 
         out += '<select name=\"newitem' + itemcnt + '\">'; 
         out += '<option value=0 selected></option>'; 
        foreach ($yasai as $ri) {
                out += '<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>'; 
        }
         out += '</select>'; 
         out += '</td>'; 
         out += '<td></td>'; 
                
          out += '<td><input type=text name=\"newcnt' + itemcnt +'\" value=\"1\" size=2> шт</td>'; 
         
          out += '<td></td>'; 
          out += '<td></td>'; 
        
        
          out += '</tr>'; 
         $(sender).parent().parent().before(out); 
        
         itemcnt++; 
        
         } 
        
        
         function addbuild(sender,bid) { 
        
         out = ''; 
        
        
         out += '<tr>'; 
                 
         out += '<td></td>'; 
         out += '<td>'; 
         out += '<select name=\"newbuild' + buildcnt + '\">'; 
         out += '<option value=0 selected></option>'; 
        foreach ($categories as $category=>$catname) {
                 out += '<option value=\"0\" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$catname."</option>'; 
                foreach ($nico[$category] as $ri) {
                        out += '<option value=\"".$ri['id']."\">&gt;".$ri['name']."</option>'; 
                }
        }
         out += '</select>'; 
         out += '</td>'; 
         out += '<td></td>'; 
                
          out += '<td><input type=hidden name=\"newrelatedbid' + buildcnt +'\" value=\"' + bid + '\"><input type=text name=\"newbuildcnt' + buildcnt +'\" value=\"1\" size=2> шт</td>'; 
         
          out += '<td></td>'; 
          out += '<td></td>'; 
        
        
          out += '</tr>'; 
         $(sender).parent().parent().before(out); 
        
         buildcnt++; 
        
         } 
        
        </script> 
		
		        $ath2 = mysql_query("SELECT * FROM ps_items2 WHERE cat = '".$cat['ctid']."' AND vis = 1 ORDER BY itsort;");
