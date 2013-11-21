# -*- coding: cp936 -*-
import re

class ApacheConfig(object):

    re_comment = re.compile(r"""^#.*$""")
    re_section_start = re.compile(r"""^<(?P<name>[^/\s>]+)\s*(?P<value>[^>]+)?>$""")
    re_section_end = re.compile(r"""^</(?P<name>[^\s>]+)\s*>$""")
    with_comment = False
    #re_statement = re.compile(r"""^(?P<name>[^\s]+)\s*(?P<value>.+)?$""")

    def __init__(self, name, values=[], section=False):
        self.name = name
        self.children = []
        self.values = values
        self.section = section


    def add_child(self, child):
        self.children.append(child)
        child.parent = self
        return child
    
    def find(self, path):
        """Return the first element wich matches the path.
        """
        pathelements = path.strip("/").split("/")
        if pathelements[0] == '':
            return self
        return self._find(pathelements,0)

    def _find(self, pathelements,start):
        
        if len(pathelements)> start: # there is still more to do ...
            next = pathelements[start]
            for child in self.children :
                if child.name == next:
                    result = child._find(pathelements,start+1)
                    if result:
                        return result
            return None
        else: # no pathelements left, result is self
            return self


    def findall(self, path):
        """Return all elements wich match the path.
        """
        pathelements = path.strip("/").split("/")
        if pathelements[0] == '':
            return [self]
        return self._findall(pathelements,0)


    def _findall(self, pathelements,start):
        if len(pathelements)>start: # there is still more to do ...
            result = []
            next = pathelements[start]
            for child in self.children:
                if child.name == next:
                    result.extend(child._findall(pathelements,start+1))
            return result
        else: # no pathelements left, result is self
            return [self]    
    

    def print_r(self, indent = -1):
        """Recursively print node.
        """
        if self.section:
            if indent >= 0:
                print "    " * indent + "<" + self.name + " " + " ".join(self.values) + ">"
            for child in self.children:
                child.print_r(indent + 1)
            if indent >= 0:
                print "    " * indent + "</" + self.name + ">"
        else:
            if indent >= 0:
                if self.name!="#":
                    print "    " * indent + self.name + " " + " ".join(self.values)
                else:
                    print "    " * indent + self.values
            
    def save_file(self,file):
        """save struct to the file
        """
        f = open(file,'w')
        self._save_file_r(f)
        f.close()
        
    def _save_file_r(self,fileobj,indent = -1):
        if self.section:
            if indent >= 0:
                fileobj.write( "    " * indent + "<" + self.name + " " + " ".join(self.values) + ">\n")
            for child in self.children:
                child._save_file_r(fileobj,indent + 1)
            if indent >= 0:
                fileobj.write( "    " * indent + "</" + self.name + ">\n")
        else:
            if indent >= 0:
                if self.name!="#":
                    fileobj.write( "    " * indent + self.name + " " + " ".join(self.values)+"\n")
                else:
                    fileobj.write( "    " * indent + self.values + "\n")

    @classmethod
    def parse_file(cls, file):
        """Parse a file.
        """
        f = open(file)
        root = cls._parse(f)
        f.close()
        return root


    @classmethod
    def parse_string(cls, string):
        """Parse a string.
        """
        return cls._parse(string.splitlines())


    @classmethod
    def _parse(cls, itobj):
        root = node = ApacheConfig('', section=True)
        for line in itobj:
            line = line.strip()
            if (len(line) == 0):
                continue
            if cls.re_comment.match(line):
                if cls.with_comment:
                    node.add_child(ApacheConfig("#", values=line, section=False))
                continue
            match = cls.re_section_start.match(line)
            if match:
                values = match.group("value").split()
                new_node = ApacheConfig(match.group("name"), values=values, section=True)
                node = node.add_child(new_node)
                continue
            match = cls.re_section_end.match(line)
            if match:
                if node.name != match.group("name"):
                    raise Exception("Section mismatch: '"+match.group("name")+"' should be '"+node.name+"'")
                node = node.parent
                continue
            
            values = line.split()
            values.append(" ")
            name = values.pop(0)
            node.add_child(ApacheConfig(name, values=values, section=False))
        return root

class CodeigniterConfig(ApacheConfig):
    re_statement = re.compile(r"""^(?P<name>\$[^\s]+)\s*=\s*(?P<value>[^\s]+)?;$""")
    with_comment = True
    @classmethod
    def _parse(cls, itobj):
        root = node = CodeigniterConfig('', section=True)
        for line in itobj:
            line = line.strip()

            match = cls.re_statement.match(line)
            if match:
                values = match.group("value").split()
                node.add_child(CodeigniterConfig(match.group("name"), values=values, section=False))
                continue
            if cls.with_comment:
                node.add_child(CodeigniterConfig("#", values=line, section=False))
        return root
                               
    def print_r(self, indent = -1):
        """Recursively print node.
        """
        if self.section:
            for child in self.children:
                child.print_r(indent + 1)
        else:
            if indent >= 0:
                if self.name!="#":
                    print "    " * indent + self.name + " = " + " ".join(self.values)+";"
                else:
                    print "    " * indent + self.values

    def _save_file_r(self,fileobj,indent = -1):
        if self.section:
            for child in self.children:
                child._save_file_r(fileobj,indent + 1)
        else:
            if indent >= 0:
                if self.name!="#":
                    fileobj.write( "    " * indent + self.name + " = " + " ".join(self.values)+";\n")
                else:
                    fileobj.write( "    " * indent + self.values + "\n")
