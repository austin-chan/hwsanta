//
//  TheTabBarController.m
//  ;
//
//  Created by Austin Chan on 12/2/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "TheTabBarController.h"

@interface TheTabBarController (){
    NSString *name;
    NSInteger userId;
}

@end

@implementation TheTabBarController

- (id)initWithCoder:(NSCoder *)aDecoder{
    self = [super initWithCoder:aDecoder];
    if(self){
        name = @"Charlie Andrews";
        userId = 1;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self navigationController].navigationBarHidden = NO;
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
