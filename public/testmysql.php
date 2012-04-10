<form action="" method="post">
  <div class="form_row">
    <div class="form_label">
      Username: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" autocomplete="off" value="" id="username" name="username">        </div>
  </div>
  <div class="form_row form_separate">
    <div class="form_label">
      Password: <span class="required">*</span>
    </div>
    <div class="form_field">
     
<input type="password" autocomplete="off" value="" id="password" name="password">        </div>
    <div class="form_label">
     Confirm Password: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="password" value="" id="confirmPassword" name="confirmPassword">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Organization Name: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="organizationName" name="organizationName">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      First Name: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="firstName" name="firstName">        </div>
    <div class="form_label">
      Last Name: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="lastName" name="lastName">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Address1: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="address1" name="address1">        </div>
    <div class="form_label">
      Address2:    </div>
    <div class="form_field">
      
<input type="text" value="" id="address2" name="address2">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      City: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="city" name="city">        </div>
    <div class="form_label">
      State: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="state" name="state">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Zip: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="zip" name="zip">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Phone: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="phone" name="phone">        </div>
    <div class="form_label">
      Fax: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="fax" name="fax">        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Email Address: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<input type="text" value="" id="email" name="email">        </div>
    <div class="form_label">
      Gender: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<select id="sex" name="sex">
    <option selected="selected" label="Male" value="male">Male</option>
    <option label="Female" value="female">Female</option>
</select>        </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      Group: <span class="required">*</span>
    </div>
    <div class="form_field">
       
<select onchange="getSubGroups()" id="groupId" name="groupId">
    <option label="--Select--" value="0">--Select--</option>
    <option label="Sales" value="1">Sales</option>
    <option label="Production" value="3">Production</option>
    <option label="AdminPanel" value="5">AdminPanel</option>
    <option label="Management" value="6">Management</option>
</select>    </div>

    <div class="form_label">
      Sub Group: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<select onchange="getRoles()" id="subGroupId" name="subGroupId">
    <option label="Sub Group" value="0">Sub Group</option>
</select>    </div>
  </div>
  <div class="form_row">
    <div class="form_label">
      User Role: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<select id="roleId" name="roleId">
    <option label="Roles" value="0">Roles</option>
</select>    </div>
    <div class="form_label">
      Supervisor: <span class="required">*</span>
    </div>
    <div class="form_field">
      
<select id="supervisorId" name="supervisorId">
    <option selected="selected" label="Select" value="">Select</option>
    <option label="Ritesh Sahu" value="-2147483648">Ritesh Sahu</option>
    <option label="Riteshsssssss Sahu" value="1">Riteshsssssss Sahu</option>
    <option label="Yatendra Singh" value="6">Yatendra Singh</option>
    <option label="asdfasd fasdfasdf" value="25">asdfasd fasdfasdf</option>
    <option label="tet test" value="26">tet test</option>
</select>    </div>
  </div>

    
  <div class="form_row">
    <div class="form_label">&nbsp;</div>
    <div class="form_field">
            
<input type="submit" value="Submit" id="submit" name="submit">      
        </div>
  </div>
</form>