<style type="text/css">

#supra_docs li p {
  font-weight: normal; 
  font-size: 12px;
  padding: 15px;
  margin: 15px;
  background-color: #EEE;
  border: 1px solid #333;
  max-width: 450px;
}

#supra_docs li {
  font-weight: bold;    
}

#supra_docs ol li {
  font-size: 18px;
}

#supra_docs ol ol li {
  font-size: 16px;    
  list-style-type:upper-roman;
}

#supra_docs ol ol ol li {
  font-size: 14px;
  list-style-type:lower-alpha;
}


</style>
<div id="supra_docs">
<h3>Supra CSV Documentation<h3>
<ol id="nav_list">
  <li>
      <a href="#configuration">Configuration</a>
  </li>
  <ol>
    <li ><a href="#user_settings">
      User Settings
    </a>
    </li>
    <li ><a href="#post_settings">
      Post Settings
    </a>
    </li>
    <ol> 
      <li ><a href="#auto_publish">
        Auto Publish
    </a>
      </li> 
      <li ><a href="#post_type">
        Post Type
    </a>
      </li>
      <li ><a href="#custom_post_type">
        Custom Post Type
    </a>
      </li>
      <li ><a href="#post_defaults"> 
        Post Defaults
    </a>
      </li>
    </ol>
    <li ><a href="#ingestion_settings">Ingestion Settings</a></li>
    <ol>
      <li ><a href="#custom_terms">
        Custom Terms
    </a>
      </li>
      <ol>
        <li ><a href="#parsing_arrays">
          Parsing Arrays
    </a>
        </li>
      </ol>  
      <li ><a href="#parse_complex_categories">
        Parse Complex Categories
    </a>
      </li>
      <li ><a href="#debug_ingestion">
        Debug Ingestion
    </a>
      </li>
      <li ><a href="#report_issues">  
        Report Issues
    </a>
      </li>
    </ol>
    <li ><a href="#csv_settings">CSV Settings</a></li>
    <ol>
      <li ><a href="#delimiter">
          Delimiter
    </a>
      </li>
      <li ><a href="#enclosure">
          Enclosure
    </a>
      </li>
      <li ><a href="#escape">
          Escape
    </a>
      </li>
    </ol>
  </ol>
  <li ><a href="#upload">Upload</a></li>
  <ol>
    <li ><a href="#file_types">
      File Types
    </a>
    </li>
    <li ><a href="#upload_crud_management">
      CRUD Management
    </a>
    </li>
  </ol>
  <li ><a href="#post_info">Post Info</a>
  </li>
  <ol>
    <li ><a href="#post_meta_presets">
      Post Meta Presets
    </a>
    </li>
    <li ><a href="#post_meta_mapping">
      Post Meta Mapping
    </a>
    </li>
    <li><a href="##post_meta_suggestions">
      Post Meta Suggestions
     </a>
    </li>
  </ol>
  <li><a href="##ingestion">Ingestion</a></li>
  <ol>
    <li><a href="#select_a_file">
      Select A File
    </a>
    </li>
    <li><a href="#ingestion_mapping_presets">
      Mapping Presets
      </a>
    </li>
    <li><a href="#ingestion_predefined">
      Predefined
      </a>
    </li>
    <ol>
      <li><a href="#predefined_categoires">
        Categories
        </a>
      </li>
      <li><a href="#predefined_tags">
        Tags
        </a>
      </li>
    </ol>
    <li><a href="#ingestion_custom_terms">
      Custom Terms
      </a>
    </li>
    <ol>
      <li>
        <a href="##term_name">
        Term Name
    </a>
        </a>
      </li>
      <li ><a href="#term_slug">
        Term Slug
    </a>
      </li>
      <li ><a href="#term_parent">
        Term Parent
    </a>
      </li>
    </ol>
    <li ><a href="#custom_postmeta">
      Custom Postmeta
    </a>
    </li>
    <li>
    <a href="#ingest">
      Ingest
    </a>
    </li>
  </ol>   
</ol>

<ol id="docs_list">
  <li id="configuration">
      Configuration
      <p>The following should give you some brief documentation and a great start with Supra CSV</p>
  </li>
  <ol>
    <li id="user_settings">
      User Settings
      <p>Provide the username and password of the posting user. This user will show up as the author of the post.</p>
    </li>
    <li id="post_settings">
      Post Settings
      <p>The are settings related to specifying the attributes of a post.</p>
    </li>
    <ol> 
      <li id="auto_publish">
        Auto Publish
        <p>Toogle the checkbox to automiatically publish all ingested posts. If no value is provided the post will be ingested as pending.</p>
      </li> 
      <li id="post_type">
        Post Type
        <p>
        Select the type of post. Custom post types can be created by the plugins. Select the type of post to affect what options you will have
        for ingesting the file. Refer to <a href="http://codex.wordpress.org/Post_Types" target="_blank">Post Types</a>
        </p>   
      </li>
      <li id="custom_post_type">
        Custom Post Type
        <p>
        You can also proivde a custom post type by providing a value. If you decide to use the custom type leave the dropdown blank.
        </p>
      </li>
      <li id="post_defaults"> 
        Post Defaults
        <p>
        Provide the default description and title when no value is provided in the ingested file.
        </p>
      </li>
    </ol>
    <li id="ingestion_settings">Ingestion Settings</li>
    <ol>
      <li id="custom_terms">
        Custom Terms
        <p>
        Terms are short for term taxonomy used to categorize posts. some examples are categories and tags among many others.
        Note the purpose of this would be to parse something other than the 'category' and 'keywords' taxonomy as these are the default
        taxonomy and will appear in <a href="#ingestion_predefined">Predefined</a> on the <a href="#ingestion">Ingestion</a> page. 
        Provide a comma separated value of all the term taxonomy you wish to ingest. 
        If the term taxonomy is supported by the post types it will appear in its own dropdown box under <a href="#ingestion_custom_terms">Custom Terms</a> 
        which will allow you to map a csv column to it. Refer to <a href="http://codex.wordpress.org/WordPress_Taxonomy" target="blank">Wordpresss Taxonomy</a>           
        </p>
      </li>
      <ol>
        <li id="parsing_arrays">
          Parsing Arrays
        <p>
          You can also provide an arbitrary value of terms within the csv files by delimiting the terms by a pipe symbol(|).
          <br />example: state|country|topography
        </p>
        </li>
      </ol>  
      <li id="parse_complex_categories">
        Parse Complex Categories
        <p>
        Mark this checkbox if you intend to provide nested categories. This functionality will allow you to ingest categories and subcategories on the fly.
        The feature works only if the category taxonomy is supported by the post.
        </p>
      </li>
      <li id="debug_ingestion">
        Debug Ingestion
        <p>
        By toggling this checkbox bebug out will display on the screen once the ingestion is complete. This will allow you to provide erros in the support forum.
        </p>
      </li>
      <li id="report_issues">  
        Report Issues
        <p>
        By toggling this checkbox each error thrown will send debug information to admin to troubleshoot what may have went wrong. The limit of error reporting per 
        ingestion is confined to 3.
        </p>
      </li>
    </ol>
    <li id="csv_settings">CSV Settings</li>
    <ol>
      <li id="delimiter">
          Delimiter
        <p>
          The delimiter is what is used to separate values and if the file was a tsv it would be \t rather than ,
        </p>
      </li>
      <li id="enclosure">
          Enclosure
        <p>
          The enclosure is used to encapsulate strings to prevent parsing issues for special characters and spaces.
        </p>
      </li>
      <li id="escape">
          Escape
        <p>
          The escape is the charater used to ignore delimiters prefixed by this character. (supported>=PHP5.3)
        </p>
      </li>
    </ol>
  </ol>
  <li id="upload">Upload</li>
  <ol>
    <li id="file_types">
      File Types
        <p>
      the following file mime types are supported: text/csv, text/comma-separated-values, application/vnd.ms-excel, text/plain, text/tsv
        </p>
    </li>
    <li id="upload_crud_management">
      CRUD Management
        <p>
      deleting previewing and downloading the file can all be handled with ease
        </p>
    </li>
  </ol>
  <li id="post_info">Post Info
        <p>
      The post meta data is the "administrative" information you provide to viewers about each post. This information usually includes 
      the author of the post, when it was written (or posted), and how the author categorized that particolar post. 
      Refer to <a href="http://codex.wordpress.org/Post_Meta_Data_Section" target="_blank">Post Meta</a>
        </p>
  </li>
  <ol>
    <li id="post_meta_presets">
      Post Meta Presets
        <p>
      You have CRUD access to creating, modifying and deleting presets on the fly. Presets help when using serveral files with the same convention.
        </p>
    </li>
    <li id="post_meta_mapping">
      Post Meta Mapping
        <p>
      You must provide the key and the value. the key is what is stored in the database to identify the post meta and the
      value is something that serves as a reference to deciphering the keys during the ingestion process.
        </p>
    </li>
    <li id="post_meta_suggestions">
      Post Meta Suggestions
        <p>
      These display when data is already populated using this post type selected in the Configuartion page. If post meta records exist for the post type
      they will display in the suggestions. Use these as a guid to identify what keys you need to map to csv columns to parse.
        </p>
    </li>
  </ol>
  <li id="ingestion">Ingestion</li>
  <ol>
    <li id="select_a_file">
      Select A File
        <p>
      Currently all uploaded files are options. This file of data you will be ingesting in the database.
        </p>
    </li>
    <li id="ingestion_mapping_presets">
      Mapping Presets
        <p>
      You will need to create mapping presets which are the state of mapping from the csv columns to the database.
      CRUD administration is provided with ease of use.      
        </p>
    </li>
    <li id="ingestion_predefined">
      Predefined
        <p>
      The title and description field map to the post_title and post_content. If no value is provided for these
      the defaolts in the Configuartion tab will used instead.
        </p>
    </li>
    <ol>
      <li id="predefined_categoires">
        Categories
        <p>
        These will only display if the category taxonomy is supported by the post type
        </p>
      </li>
      <li id="predefined_tags">
        Tags
        <p>
        These will only display if the keyword taxonomy is supported by the post type.
        </p>
      </li>
    </ol>
    <li id="ingestion_custom_terms">
      Custom Terms
    </li>
    <ol>
      <li id="term_name">
        Term Name
        <p>
        This will obviosly be the names of the term
        </p>
      </li>
      <li id="term_slug">
        Term Slug
        <p>
        This is the slug of the term. 
        </p>
      </li>
      <li id="term_parent">
        Term Parent
        <p>
        This should be the name of the parent term. This will establish a heierarchy between the two terms.
        </p>
      </li>
    </ol>
    <li id="custom_postmeta">
      Custom Postmeta
      <p>
      These will provide all of the post meta keys specified in the currently selected preset of the <a href="#post_info">Post Info</a> page
      </p>
    </li>
    <li id="ingest">
      Ingest
      <p>
      This will show a circular loader indicating to you that it is parsing the file. This may take a while.. if it takes longer
      than usual it may be related to php maximum execution limit or another php fatal error. You can toggle wordpress debug mode in the 
      wp-config.php to better troubleshoot this. If any errors are thrown they will be indicated in red with some descriptive 
      error information. If debug ingestion is enabled the result of the ingestion will be pretty ugly. 
      </p>
    </li>
  </ol>   
</ol>
</div>
