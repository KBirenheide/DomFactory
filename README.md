# DomFactory
A PHP class for the streamlined and consolidated creation of HTML Documents with JavaScript scripts and jQuery listeners.

The script domfactory.php contains the class, domtest.php contains an example implementation. domfactory.php is fully commented.
This was a scripting experiment to look into more efficient ways to construct HTML documents in PHP that contain jQuery listeners. Once a jQuery library has been added with addScript(), event listeners can be added with setJQueryListener(). The class has two usage modes. If the first argument in each dom element creation function is set to true, the element is appended to an internal parameter later used to construct a fully formed document. If set to false, the created element will be returned as a string. 
