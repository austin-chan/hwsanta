//
//  HomeViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "HomeViewController.h"
#import "SantaModel.h"

@interface HomeViewController (){
    NSURLConnection *connection;
}

@end

@implementation HomeViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self setupCountdown];
    [self checkMyRecipient];
    [self checkMySanta];
    [self checkMyName];
	// Do any additional setup after loading the view.
}

- (void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    self.tabBarController.title = @"HW Santa";
    self.tabBarController.navigationItem.rightBarButtonItem = nil;
}

- (void)setupCountdown{
    NSLog(@"SDF");
    int days = [[SantaModel sharedSantaModel] daysUntilSantageddon];
    self.countdownLabel.text = [NSString stringWithFormat:@"%d", days];
}
- (void)checkMyRecipient{
    NSString *recipient = [[SantaModel sharedSantaModel] checkMyRecipient:[SantaModel getU]];
    if(recipient != nil){
        self.recipientLabel.text = recipient;
    }
}

- (void)checkMySanta{
    NSString *santa = [[SantaModel sharedSantaModel] checkMySanta:[SantaModel getU]];
    if(santa != nil){
        self.santaLabel.text = santa;
    }
}

- (void)checkMyName{
    NSString *name = [[SantaModel sharedSantaModel] checkMyName:[SantaModel getU]];
    if(name != nil){
        self.nameLabel.text = name;
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
