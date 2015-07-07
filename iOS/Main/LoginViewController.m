//
//  LoginViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "LoginViewController.h"
#import "TheNavigationController.h"
#import "SantaModel.h"

@interface LoginViewController (){
    BOOL isRequesting;
}

@end

@implementation LoginViewController

// Like I said, when the view did load
- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [self.activity setHidden:YES];
    [self navigationController].navigationBarHidden = NO;
    [self prepTheBackground];
    [self prepTheButtons];
}

// Preps the background image
- (void)prepTheBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"debut_light.png"]];
    self.view.backgroundColor = backgroundColor;
}
// Preps the styling of the back button
- (void)prepTheButtons{
    UIImage *buttonImage = [[UIImage imageNamed:@"orangeButton.png"]
                            resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *buttonImageHighlight = [[UIImage imageNamed:@"orangeButtonHighlight.png"]
                                     resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    // Set the background for any states you plan to use
    [self.backToRegisterButton setBackgroundImage:buttonImage forState:UIControlStateNormal];
    [self.backToRegisterButton setBackgroundImage:buttonImageHighlight forState:UIControlStateHighlighted];
    
    UIImage *buttonImage2 = [[UIImage imageNamed:@"greenButton.png"]
                            resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *buttonImageHighlight2 = [[UIImage imageNamed:@"greenButtonHighlight.png"]
                                     resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    // Set the background for any states you plan to use
    [self.loginButton setBackgroundImage:buttonImage2 forState:UIControlStateNormal];
    [self.loginButton setBackgroundImage:buttonImageHighlight2 forState:UIControlStateHighlighted];
}

// When the back button is pressed
- (IBAction)backToRegister:(id)sender {
    [[self presentingViewController] dismissViewControllerAnimated:YES completion:nil];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField{
    if(textField == self.emailField){
        [textField resignFirstResponder];
        [self.passwordField becomeFirstResponder];
    }else{
        [self login:nil];
    }
    return NO;
}

- (IBAction)login:(id)sender {
    
    NSString *username = self.emailField.text;
    NSString *password = self.passwordField.text;
    
    
    if([username length] != 0 && [password length] != 0){
        if(isRequesting) return;
        [[SantaModel sharedSantaModel] loginRequestWithUsername:username andPassword:password forLoginView:self];
        [self.activity setHidden:NO];
        isRequesting = YES;
    }else{
        [[[UIAlertView alloc] initWithTitle:@"Incomplete" message:@"Please complete all the fields to login" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
    }
}

- (void)readyToLogin{
    isRequesting = NO;
    [(TheNavigationController *)self.presentingViewController login];
}

- (void)notReadyToLogin{
    isRequesting = YES;
    [self.activity setHidden:YES];
}

@end
