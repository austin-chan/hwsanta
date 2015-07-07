//
//  WelcomeRulesViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/30/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "AcceptRulesViewController.h"
#import "TheNavigationController.h"
#import <QuartzCore/QuartzCore.h>

@interface AcceptRulesViewController (){
    
}

@end

@implementation AcceptRulesViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    [[self navigationController] setNavigationBarHidden:YES animated:YES];
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self prepButtons];
}

- (void)prepButtons{
    //White Button
    UIImage *greyButton = [[UIImage imageNamed:@"greyButton.png"] resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *greyButtonPressed = [[UIImage imageNamed:@"greyButtonHighlight.png"] resizableImageWithCapInsets:UIEdgeInsetsMake(18,18,18,18)];
    
    [self.acceptButton setBackgroundImage:greyButton forState:UIControlStateNormal];
    [self.acceptButton setBackgroundImage:greyButtonPressed forState:UIControlStateHighlighted];
    
    [self.declineButton setBackgroundImage:greyButton forState:UIControlStateNormal];
    [self.declineButton setBackgroundImage:greyButtonPressed forState:UIControlStateHighlighted];
}

- (IBAction)rulesAccepted:(id)sender {
    [(TheNavigationController *)[self navigationController] nextAfterRules];
}

- (IBAction)rulesDeclined:(id)sender {
    [(TheNavigationController *)[self navigationController] backBeforeRules];
}
@end
