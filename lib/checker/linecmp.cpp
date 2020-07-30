#include "testlib.h"
#include <string>
#include<bits/stdc++.h>
using namespace std;


int main(int argc, char * argv[])
{	
	setName("Check Line Same Or Not");
    registerTestlibCmd(argc, argv);
    vector<string>outV,ansV;

    while(!ouf.eof()){
    	string st = ouf.readString();
    	outV.push_back(st);
	}

	while(!ans.eof()){
    	string st = ans.readString();
    	ansV.push_back(st);
	}

	if(ansV.size()!=outV.size())
		quitf(_wa, "expected output is not same");
	for(int i=0; i<ansV.size(); i++){
		if(ansV[i] != outV[i])
			quitf(_wa, "expected output is not same in line %d",i+1);
	}

    quitf(_ok, "%d lines",(int)ansV.size());
}